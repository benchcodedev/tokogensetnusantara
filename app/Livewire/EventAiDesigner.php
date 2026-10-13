<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\ThemeVersion;
use App\Services\AiDesignService;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventAiDesigner extends Component
{
    use WithFileUploads;

    public Event $event;
    public string $prompt = '';
    public $referenceImage = null;
    public bool $allowCustomCss = false;
    public ?int $selectedVersionId = null;
    public ?int $revisionVersionId = null;
    public string $viewMode = 'mobile'; // 'mobile' (390px) or 'desktop' (full)

    protected function rules(): array
    {
        return [
            'prompt' => 'required|string|min:3|max:1000',
            'referenceImage' => 'nullable|image|max:5120', // max 5MB
            'allowCustomCss' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'prompt.required' => 'Permintaan desain (prompt) wajib diisi.',
            'prompt.min' => 'Permintaan desain minimal 3 karakter.',
            'prompt.max' => 'Permintaan desain maksimal 1000 karakter.',
            'referenceImage.image' => 'File referensi harus berupa gambar (JPG, PNG, WebP).',
            'referenceImage.max' => 'Ukuran gambar referensi maksimal 5 MB.',
        ];
    }

    public function mount(Event $event): void
    {
        $this->event = $event;

        // Pilih versi terakhir yang ada, prioritaskan yang dipublikasikan atau draft terbaru
        $activeVersion = ThemeVersion::where('event_id', $this->event->id)
            ->orderByRaw("CASE WHEN status = 'published' THEN 1 ELSE 2 END")
            ->latest('id')
            ->first();

        $this->selectedVersionId = $activeVersion?->id;
    }

    public function getRemainingQuotaProperty(): int
    {
        return AiDesignService::getRemainingQuota($this->event->id);
    }

    public function getThemeVersionsProperty()
    {
        return ThemeVersion::where('event_id', $this->event->id)
            ->latest('id')
            ->get();
    }

    public function getSelectedVersionProperty(): ?ThemeVersion
    {
        if (!$this->selectedVersionId) {
            return null;
        }

        return ThemeVersion::where('event_id', $this->event->id)
            ->find($this->selectedVersionId);
    }

    public function setQuickPrompt(string $text): void
    {
        $this->prompt = $text;
    }

    public function setViewMode(string $mode): void
    {
        $this->viewMode = $mode === 'desktop' ? 'desktop' : 'mobile';
    }

    public function selectVersion(int $versionId): void
    {
        $this->selectedVersionId = $versionId;
    }

    public function prepareRevision(int $versionId): void
    {
        $version = ThemeVersion::where('event_id', $this->event->id)->findOrFail($versionId);
        $this->revisionVersionId = $versionId;
        $this->selectedVersionId = $versionId;
        $this->prompt = "Revisi Versi #{$versionId}: ";

        Notification::make()
            ->title('Mode Revisi Aktif')
            ->body("Silakan tuliskan instruksi revisi untuk menyempurnakan Versi #{$versionId}.")
            ->info()
            ->send();
    }

    public function cancelRevision(): void
    {
        $this->revisionVersionId = null;
        Notification::make()
            ->title('Mode Revisi Dibatalkan')
            ->body('Anda kembali ke mode pembuatan tema baru.')
            ->send();
    }

    public function generate(AiDesignService $service): void
    {
        $this->validate();

        if ($this->remainingQuota <= 0) {
            Notification::make()
                ->title('Batas Kuota Tercapai')
                ->body('Batas pemanggilan AI harian untuk acara ini telah tercapai (maksimal 10 kali/hari). Silakan coba lagi besok.')
                ->danger()
                ->send();
            return;
        }

        try {
            $refPath = null;
            if ($this->referenceImage) {
                $refPath = $this->referenceImage->store('ai_references', 'public');
            }

            $result = $service->generate(
                $this->event,
                $this->prompt,
                $refPath,
                $this->allowCustomCss,
                $this->revisionVersionId,
                auth()->user()
            );

            $this->selectedVersionId = $result['version']->id;
            $this->revisionVersionId = null;
            $this->referenceImage = null;

            Notification::make()
                ->title('Desain AI Berhasil Dibuat!')
                ->body("Versi #{$result['version']->id} berhasil di-generate sebagai draft. Pratinjau langsung diperbarui di bawah.")
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Gagal Membuat Desain')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function applyVersion(int $versionId): void
    {
        $version = ThemeVersion::where('event_id', $this->event->id)->findOrFail($versionId);

        // Update konfigurasi event
        $template = $version->theme['template'] ?? $this->event->template;
        $this->event->update([
            'template' => $template,
            'theme' => $version->theme,
            'custom_css' => $version->custom_css,
        ]);

        // Perbarui status semua versi untuk event ini
        ThemeVersion::where('event_id', $this->event->id)->update(['status' => 'draft']);
        ThemeVersion::where('id', $versionId)->update(['status' => 'published']);
        $version->refresh();

        $this->event->refresh();
        $this->selectedVersionId = $version->id;

        Notification::make()
            ->title('Tema Berhasil Diterapkan!')
            ->body("Versi #{$versionId} sekarang aktif dan resmi digunakan pada undangan publik.")
            ->success()
            ->send();
    }

    public function revertVersion(int $versionId): void
    {
        $this->applyVersion($versionId);

        Notification::make()
            ->title('Berhasil Dikembalikan!')
            ->body("Undangan berhasil dikembalikan ke Versi #{$versionId}.")
            ->warning()
            ->send();
    }

    public function render()
    {
        return view('livewire.event-ai-designer', [
            'remainingQuota' => $this->remainingQuota,
            'versions' => $this->themeVersions,
            'selectedVersion' => $this->selectedVersion,
        ]);
    }
}
