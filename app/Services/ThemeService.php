<?php

namespace App\Services;

class ThemeService
{
    /**
     * Daftar Google Fonts yang diizinkan untuk Heading
     */
    public const ALLOWED_HEADING_FONTS = [
        'Playfair Display' => 'Playfair Display (Klasik & Romantis)',
        'Cormorant Garamond' => 'Cormorant Garamond (Earthy & Serif Elegan)',
        'Cinzel' => 'Cinzel (Modern & Megah)',
        'Great Vibes' => 'Great Vibes (Kaligrafi Bersambung)',
        'Merriweather' => 'Merriweather (Serif Hangat)',
        'Lora' => 'Lora (Serif Kontemporer)',
    ];

    /**
     * Daftar Google Fonts yang diizinkan untuk Body
     */
    public const ALLOWED_BODY_FONTS = [
        'Plus Jakarta Sans' => 'Plus Jakarta Sans (Modern & Bersih)',
        'Montserrat' => 'Montserrat (Geometris)',
        'Inter' => 'Inter (Netral & Mudah Dibaca)',
        'Nunito Sans' => 'Nunito Sans (Ramah & Lembut)',
        'Open Sans' => 'Open Sans (Klasik Sans-serif)',
    ];

    /**
     * Daftar Efek Background yang Diizinkan
     */
    public const ALLOWED_BACKGROUND_EFFECTS = [
        'petals' => 'Kelopak Bunga Berguguran (Petals)',
        'gold_particles' => 'Partikel Emas Berkilau (Gold Dust)',
        'fireflies' => 'Kunang-Kunang Berpendar (Fireflies)',
        'snow' => 'Butiran Salju Lembut (Snow)',
        'none' => 'Tanpa Efek Gerak (None)',
    ];

    /**
     * Daftar Gaya Cover yang Diizinkan
     */
    public const ALLOWED_COVER_STYLES = [
        'romantic-floral' => 'Romantic Floral (Frame Bunga & Romantis)',
        'fullscreen-dark' => 'Fullscreen Dark (Elegan Sinematik Gelap)',
        'minimal-card' => 'Minimal Card (Kartu Bersih Modern)',
    ];

    /**
     * Preset bawaan 3 template awal
     */
    public const TEMPLATES = [
        'elegan-floral' => [
            'name' => 'Elegan Floral',
            'description' => 'Nuansa floral romantis beraksen emas dan mawar lembut',
            'theme' => [
                'color_primary' => '#8B5E3C',
                'color_secondary' => '#D4AF37',
                'color_accent' => '#C5A880',
                'color_bg' => '#FDFBF7',
                'color_text' => '#2D2D2D',
                'font_heading' => 'Playfair Display',
                'font_body' => 'Plus Jakarta Sans',
                'efek_background' => 'petals',
                'gaya_cover' => 'romantic-floral',
            ],
        ],
        'rustic' => [
            'name' => 'Rustic Nature',
            'description' => 'Nuansa alam, kayu hangat, terracotta, dan sage green',
            'theme' => [
                'color_primary' => '#5C4033',
                'color_secondary' => '#6B705C',
                'color_accent' => '#B7B7A4',
                'color_bg' => '#F7F4EF',
                'color_text' => '#332D29',
                'font_heading' => 'Cormorant Garamond',
                'font_body' => 'Montserrat',
                'efek_background' => 'fireflies',
                'gaya_cover' => 'fullscreen-dark',
            ],
        ],
        'minimalis' => [
            'name' => 'Minimalis Modern',
            'description' => 'Gaya monokrom bersih, spasi lapang, dan garis tegas',
            'theme' => [
                'color_primary' => '#1E293B',
                'color_secondary' => '#64748B',
                'color_accent' => '#94A3B8',
                'color_bg' => '#FFFFFF',
                'color_text' => '#0F172A',
                'font_heading' => 'Cinzel',
                'font_body' => 'Inter',
                'efek_background' => 'gold_particles',
                'gaya_cover' => 'minimal-card',
            ],
        ],
    ];

    /**
     * Resolusi tema final dengan fallback aman
     */
    public static function resolveTheme(?string $template, ?array $customTheme = []): array
    {
        $templateKey = array_key_exists($template, self::TEMPLATES) ? $template : 'elegan-floral';
        $preset = self::TEMPLATES[$templateKey]['theme'];

        $merged = array_merge($preset, array_filter($customTheme ?? [], fn($v) => !is_null($v) && $v !== ''));

        // Validasi font agar selalu ada di daftar yang diizinkan
        if (!array_key_exists($merged['font_heading'], self::ALLOWED_HEADING_FONTS)) {
            $merged['font_heading'] = $preset['font_heading'];
        }
        if (!array_key_exists($merged['font_body'], self::ALLOWED_BODY_FONTS)) {
            $merged['font_body'] = $preset['font_body'];
        }

        // Validasi efek background
        if (!array_key_exists($merged['efek_background'], self::ALLOWED_BACKGROUND_EFFECTS)) {
            $merged['efek_background'] = $preset['efek_background'];
        }

        return $merged;
    }
}
