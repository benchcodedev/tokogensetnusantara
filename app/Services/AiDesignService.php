<?php

namespace App\Services;

use App\Models\AiGenerationLog;
use App\Models\DesignAsset;
use App\Models\Event;
use App\Models\ThemeVersion;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiDesignService
{
    public const MAX_DAILY_GENERATIONS = 10;

    /**
     * Cek sisa kuota generate harian untuk sebuah event
     */
    public static function getRemainingQuota(int $eventId): int
    {
        $usedCount = AiGenerationLog::where('event_id', $eventId)
            ->whereDate('created_at', today())
            ->where('is_success', true)
            ->count();

        return max(0, self::MAX_DAILY_GENERATIONS - $usedCount);
    }

    /**
     * Memanggil AI untuk menghasilkan tema (Tingkat A & opsional Tingkat B)
     */
    public function generate(
        Event $event,
        string $prompt,
        ?string $referenceImagePath = null,
        bool $allowCustomCss = false,
        ?int $previousVersionId = null,
        ?User $user = null
    ): array {
        // 1. Cek Kuota Harian
        $remaining = self::getRemainingQuota($event->id);
        if ($remaining <= 0) {
            throw new \Exception('Batas pemanggilan AI harian untuk acara ini telah tercapai (maksimal 10 kali/hari). Silakan coba lagi besok.');
        }

        $apiKey = env('ANTHROPIC_API_KEY');
        $model = env('ANTHROPIC_MODEL', 'claude-3-5-sonnet-20241022');

        // 2. Siapkan Konteks & Skema Sistem
        $systemPrompt = $this->buildSystemPrompt($allowCustomCss);
        $userMessage = $this->buildUserMessage($prompt, $previousVersionId, $referenceImagePath);

        $rawResponse = null;
        $decodedJson = null;

        try {
            if (!empty($apiKey) && !app()->environment('testing')) {
                // Panggil Claude API (Anthropic)
                $rawResponse = $this->callAnthropicApi($apiKey, $model, $systemPrompt, $userMessage);
            } else {
                // Fallback Mock Generator cerdas (untuk lokal tanpa key / unit testing)
                $rawResponse = $this->generateMockResponse($prompt, $allowCustomCss, $previousVersionId);
            }

            // 3. Ekstrak dan Parse JSON
            $cleanJsonString = $this->extractJson($rawResponse);
            $decodedJson = json_decode($cleanJsonString, true);

            if (!is_array($decodedJson)) {
                throw new \Exception('Respon AI bukan merupakan format JSON yang valid.');
            }

            // 4. Validasi Tingkat A (Skema Tema & Nilai yang Diizinkan)
            $validatedThemeData = $this->validateLevelA($decodedJson);

            // 5. Validasi Tingkat B (Custom CSS Tambahan)
            $sanitizedCss = null;
            if ($allowCustomCss && !empty($decodedJson['custom_css'])) {
                $scope = '.template-' . $validatedThemeData['template'];
                [$isValidCss, $cssResult, $cssError] = CssSanitizerService::sanitize($decodedJson['custom_css'], $scope);
                if ($isValidCss) {
                    $sanitizedCss = $cssResult;
                } else {
                    Log::warning('CSS AI ditolak oleh sanitizer: ' . $cssError);
                }
            }

            // 6. Simpan Draft di ThemeVersion
            $themeDataToSave = $validatedThemeData['theme'];
            $themeDataToSave['template'] = $validatedThemeData['template'];

            $themeVersion = ThemeVersion::create([
                'event_id' => $event->id,
                'theme' => $themeDataToSave,
                'custom_css' => $sanitizedCss,
                'prompt' => $prompt,
                'created_by' => $user ? $user->name : 'Admin EO',
                'status' => 'draft',
            ]);

            // 7. Catat Log Berhasil
            AiGenerationLog::create([
                'event_id' => $event->id,
                'user_id' => $user?->id,
                'prompt' => $prompt,
                'reference_image' => $referenceImagePath,
                'allow_custom_css' => $allowCustomCss,
                'raw_response' => $rawResponse,
                'is_success' => true,
            ]);

            return [
                'success' => true,
                'version' => $themeVersion,
                'template' => $validatedThemeData['template'],
                'theme' => $validatedThemeData['theme'],
                'custom_css' => $sanitizedCss,
            ];
        } catch (\Throwable $e) {
            // Catat Log Kegagalan
            AiGenerationLog::create([
                'event_id' => $event->id,
                'user_id' => $user?->id,
                'prompt' => $prompt,
                'reference_image' => $referenceImagePath,
                'allow_custom_css' => $allowCustomCss,
                'raw_response' => $rawResponse,
                'is_success' => false,
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Memanggil Anthropic Messages API
     */
    protected function callAnthropicApi(string $apiKey, string $model, string $systemPrompt, array $userMessageContent): string
    {
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->timeout(45)->post('https://api.anthropic.com/v1/messages', [
            'model' => $model,
            'max_tokens' => 2000,
            'system' => $systemPrompt,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $userMessageContent,
                ],
            ],
        ]);

        if ($response->failed()) {
            $status = $response->status();
            $body = $response->json();
            $errMsg = $body['error']['message'] ?? $response->body();
            throw new \Exception("Gagal menghubungi Claude API (HTTP {$status}): {$errMsg}");
        }

        $resJson = $response->json();
        return $resJson['content'][0]['text'] ?? '';
    }

    /**
     * Bangun system prompt dengan skema JSON dan whitelist ketat
     */
    protected function buildSystemPrompt(bool $allowCustomCss): string
    {
        $allowedTemplates = implode(', ', array_keys(ThemeService::TEMPLATES));
        $allowedHeadingFonts = implode(', ', array_keys(ThemeService::ALLOWED_HEADING_FONTS));
        $allowedBodyFonts = implode(', ', array_keys(ThemeService::ALLOWED_BODY_FONTS));
        $allowedEffects = implode(', ', array_keys(ThemeService::ALLOWED_BACKGROUND_EFFECTS));
        $allowedCoverStyles = implode(', ', array_keys(ThemeService::ALLOWED_COVER_STYLES));

        $assets = DesignAsset::select('nama', 'kategori', 'tag')->take(10)->get();
        $assetsList = $assets->map(fn($a) => "{$a->nama} ({$a->kategori})")->implode(', ');

        $cssInstruction = $allowCustomCss
            ? "You may provide additional scoped CSS in 'custom_css' (e.g. subtle shadow, border flourish). Do NOT use @import, external url(), or javascript."
            : "Set 'custom_css' to null or empty string.";

        return <<<PROMPT
You are a world-class luxury digital wedding invitation art director.
Your task is to generate or revise a wedding invitation theme configuration based on the user's design request.

You MUST respond strictly with a valid JSON object without markdown code blocks, backticks, or explanatory text.

JSON Schema:
{
  "template": "one of: {$allowedTemplates}",
  "theme": {
    "color_primary": "#HEX (Main brand color for titles/buttons)",
    "color_secondary": "#HEX (Secondary color for gold accents/borders)",
    "color_accent": "#HEX (Soft accent color)",
    "color_bg": "#HEX (Page background color)",
    "color_text": "#HEX (Readable text color)",
    "font_heading": "one of: {$allowedHeadingFonts}",
    "font_body": "one of: {$allowedBodyFonts}",
    "efek_background": "one of: {$allowedEffects}",
    "gaya_cover": "one of: {$allowedCoverStyles}"
  },
  "custom_css": {$cssInstruction}
}

Available Design Assets in library: {$assetsList}

Guidelines:
1. Colors must have high contrast and harmonious wedding aesthetic.
2. Only pick fonts, effects, and templates from the exact allowed lists.
PROMPT;
    }

    /**
     * Format isi pesan pengguna (teks + gambar referensi jika ada)
     */
    protected function buildUserMessage(string $prompt, ?int $previousVersionId, ?string $referenceImagePath): array
    {
        $content = [];

        $textPrompt = "Design request: " . $prompt;

        if ($previousVersionId) {
            $prev = ThemeVersion::find($previousVersionId);
            if ($prev) {
                $textPrompt .= "\n\nThis is a REVISION of a previous theme version: " . json_encode($prev->theme) . ". Please modify this version according to the request above.";
            }
        }

        $content[] = [
            'type' => 'text',
            'text' => $textPrompt,
        ];

        // Lampirkan gambar referensi jika ada
        if ($referenceImagePath && file_exists(storage_path('app/' . $referenceImagePath))) {
            $fullPath = storage_path('app/' . $referenceImagePath);
            $mime = mime_content_type($fullPath) ?: 'image/jpeg';
            $data = base64_encode(file_get_contents($fullPath));

            $content[] = [
                'type' => 'image',
                'source' => [
                    'type' => 'base64',
                    'media_type' => $mime,
                    'data' => $data,
                ],
            ];
        }

        return $content;
    }

    /**
     * Ekstraksi JSON murni dari teks respon AI
     */
    protected function extractJson(string $raw): string
    {
        $trimmed = trim($raw);

        // Bersihkan markdown ```json ... ```
        if (preg_match('/```(?:json)?\s*(\{.*?\})\s*```/s', $trimmed, $matches)) {
            return $matches[1];
        }

        // Cari blok kurung kurawal pertama dan terakhir
        $start = strpos($trimmed, '{');
        $end = strrpos($trimmed, '}');

        if ($start !== false && $end !== false && $end > $start) {
            return substr($trimmed, $start, $end - $start + 1);
        }

        return $trimmed;
    }

    /**
     * Validasi Ketat Tingkat A terhadap Skema Tema
     */
    public function validateLevelA(array $data): array
    {
        $template = $data['template'] ?? 'elegan-floral';
        if (!array_key_exists($template, ThemeService::TEMPLATES)) {
            $template = 'elegan-floral';
        }

        $theme = $data['theme'] ?? [];

        // Validasi dan normalisasi warna hex
        $colorKeys = ['color_primary', 'color_secondary', 'color_accent', 'color_bg', 'color_text'];
        $preset = ThemeService::TEMPLATES[$template]['theme'];

        foreach ($colorKeys as $key) {
            $val = trim((string)($theme[$key] ?? ''));
            if (!preg_match('/^#[a-f0-9]{6}$/i', $val)) {
                $theme[$key] = $preset[$key];
            }
        }

        // Validasi Font
        if (empty($theme['font_heading']) || !array_key_exists($theme['font_heading'], ThemeService::ALLOWED_HEADING_FONTS)) {
            $theme['font_heading'] = $preset['font_heading'];
        }

        if (empty($theme['font_body']) || !array_key_exists($theme['font_body'], ThemeService::ALLOWED_BODY_FONTS)) {
            $theme['font_body'] = $preset['font_body'];
        }

        // Validasi Efek Background
        if (empty($theme['efek_background']) || !array_key_exists($theme['efek_background'], ThemeService::ALLOWED_BACKGROUND_EFFECTS)) {
            $theme['efek_background'] = $preset['efek_background'];
        }

        // Validasi Gaya Cover
        if (empty($theme['gaya_cover']) || !array_key_exists($theme['gaya_cover'], ThemeService::ALLOWED_COVER_STYLES)) {
            $theme['gaya_cover'] = $preset['gaya_cover'];
        }

        return [
            'template' => $template,
            'theme' => $theme,
        ];
    }

    /**
     * Mock generator cerdas untuk pengujian tanpa external API key
     */
    protected function generateMockResponse(string $prompt, bool $allowCustomCss, ?int $previousVersionId): string
    {
        $p = strtolower($prompt);

        if (str_contains($p, 'rustic') || str_contains($p, 'alam') || str_contains($p, 'kayu') || str_contains($p, 'sage') || str_contains($p, 'terakota') || str_contains($p, 'pantai')) {
            $template = 'rustic';
            $primary = str_contains($p, 'terakota') ? '#A0522D' : '#5C4033';
            $secondary = '#6B705C';
            $accent = '#B7B7A4';
            $bg = '#F7F4EF';
            $text = '#332D29';
            $heading = 'Cormorant Garamond';
            $body = 'Montserrat';
            $effect = 'fireflies';
            $cover = 'fullscreen-dark';
        } elseif (str_contains($p, 'minimalis') || str_contains($p, 'monokrom') || str_contains($p, 'modern') || str_contains($p, 'simple') || str_contains($p, 'hitam')) {
            $template = 'minimalis';
            $primary = '#1E293B';
            $secondary = '#64748B';
            $accent = '#94A3B8';
            $bg = '#FFFFFF';
            $text = '#0F172A';
            $heading = 'Cinzel';
            $body = 'Inter';
            $effect = 'gold_particles';
            $cover = 'minimal-card';
        } else {
            $template = 'elegan-floral';
            $primary = '#8B5E3C';
            $secondary = '#D4AF37';
            $accent = '#C5A880';
            $bg = '#FDFBF7';
            $text = '#2D2D2D';
            $heading = 'Playfair Display';
            $body = 'Plus Jakarta Sans';
            $effect = 'petals';
            $cover = 'romantic-floral';
        }

        $customCss = $allowCustomCss
            ? ".hero-title { text-shadow: 0 2px 4px rgba(0,0,0,0.1); }\n.date-badge { border: 1px solid var(--color-secondary); }"
            : "";

        return json_encode([
            'template' => $template,
            'theme' => [
                'color_primary' => $primary,
                'color_secondary' => $secondary,
                'color_accent' => $accent,
                'color_bg' => $bg,
                'color_text' => $text,
                'font_heading' => $heading,
                'font_body' => $body,
                'efek_background' => $effect,
                'gaya_cover' => $cover,
            ],
            'custom_css' => $customCss,
        ]);
    }
}
