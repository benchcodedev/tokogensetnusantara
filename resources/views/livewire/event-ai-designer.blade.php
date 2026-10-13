<div class="space-y-6">
    {{-- Header Banner & Kuota Harian --}}
    <div class="bg-gradient-to-r from-amber-50 via-rose-50 to-amber-100/60 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 border border-amber-200 dark:border-gray-700 rounded-2xl p-5 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-3 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        AI Design Assistant
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-300">
                            Claude 3.5 Sonnet
                        </span>
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-0.5">
                        Eksplorasi tema, palet warna, tipografi, dan ornamen undangan secara instan melalui instruksi bahasa alami.
                    </p>
                </div>
            </div>

            {{-- Kuota Badge --}}
            <div class="flex items-center gap-2 bg-white dark:bg-gray-800 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm self-start md:self-auto">
                <div class="w-3 h-3 rounded-full {{ $remainingQuota > 3 ? 'bg-emerald-500 animate-pulse' : ($remainingQuota > 0 ? 'bg-amber-500' : 'bg-rose-500') }}"></div>
                <div class="text-xs">
                    <div class="font-bold {{ $remainingQuota > 3 ? 'text-emerald-700 dark:text-emerald-400' : ($remainingQuota > 0 ? 'text-amber-700 dark:text-amber-400' : 'text-rose-700 dark:text-rose-400') }}">
                        Sisa Kuota: {{ $remainingQuota }} / 10
                    </div>
                    <div class="text-[11px] text-gray-500 dark:text-gray-400">Panggilan per hari</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Workspace: Generator (Kiri) + Preview (Kanan) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {{-- KOLOM KIRI: FORM GENERATE & RIWAYAT (7 Kolom) --}}
        <div class="lg:col-span-7 space-y-6">
            {{-- Form Generator AI --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm space-y-4">
                {{-- Banner Mode Revisi jika aktif --}}
                @if($revisionVersionId)
                    <div class="bg-sky-50 dark:bg-sky-950/40 border border-sky-200 dark:border-sky-800 rounded-xl p-3.5 flex items-center justify-between text-xs text-sky-800 dark:text-sky-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>
                                <strong>Mode Revisi Versi #{{ $revisionVersionId }}:</strong> AI akan menyempurnakan palet & gaya dari versi sebelumnya.
                            </span>
                        </div>
                        <button type="button" wire:click="cancelRevision" class="font-bold underline hover:text-sky-900 ml-2 whitespace-nowrap">
                            Batal Revisi
                        </button>
                    </div>
                @endif

                {{-- Preset Quick Prompts --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                        Inspirasi Cepat (Klik untuk menerapkan):
                    </label>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" wire:click="setQuickPrompt('Earthy Rustic hangat dengan sentuhan daun sage, terakota alam, dan efek kunang-kunang')"
                            class="text-[11px] px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-amber-800 dark:text-amber-300 hover:bg-amber-100 transition">
                            🌿 Rustic Terracotta & Sage
                        </button>
                        <button type="button" wire:click="setQuickPrompt('Nuansa Royal Wedding mewah dengan warna emas champagne, putih mutiara, dan partikel emas berkilau')"
                            class="text-[11px] px-2.5 py-1 rounded-lg bg-yellow-50 dark:bg-yellow-950/40 border border-yellow-200 dark:border-yellow-800/60 text-yellow-800 dark:text-yellow-300 hover:bg-yellow-100 transition">
                            ✨ Royal Golden Champagne
                        </button>
                        <button type="button" wire:click="setQuickPrompt('Minimalis monokrom elegan modern dengan tipografi serif klasik dan aksen abu-abu slate bersih')"
                            class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-300 hover:bg-slate-100 transition">
                            🖤 Minimalis Monokrom Modern
                        </button>
                        <button type="button" wire:click="setQuickPrompt('Romantis floral lembut warna dusty pink, kelopak mawar jatuh, dan sentuhan font Playfair Display')"
                            class="text-[11px] px-2.5 py-1 rounded-lg bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-rose-800 dark:text-rose-300 hover:bg-rose-100 transition">
                            🌸 Romantic Dusty Rose
                        </button>
                    </div>
                </div>

                {{-- Textarea Permintaan Desain (Prompt) --}}
                <div>
                    <label for="prompt" class="block text-xs font-bold text-gray-700 dark:text-gray-200 mb-1">
                        Permintaan Desain (Prompt) <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        id="prompt"
                        wire:model="prompt"
                        rows="3"
                        placeholder="Contoh: Buatkan tema pernikahan pantai Bali senja dengan nuansa oranye hangat, emas, font Cormorant Garamond, dan partikel kelopak bunga..."
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm shadow-sm focus:border-amber-500 focus:ring-amber-500"
                    ></textarea>
                    @error('prompt')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Grid: Upload Referensi & Toggle Custom CSS --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    {{-- Upload Gambar Referensi --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 mb-1">
                            Gambar Referensi Moodboard (Opsional)
                        </label>
                        <input
                            type="file"
                            wire:model="referenceImage"
                            accept="image/png,image/jpeg,image/webp"
                            class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 dark:file:bg-amber-950/60 dark:file:text-amber-300 hover:file:bg-amber-100"
                        />
                        <div wire:loading wire:target="referenceImage" class="text-[11px] text-amber-600 mt-1">
                            Mengunggah gambar...
                        </div>
                        @if ($referenceImage)
                            <div class="mt-2 flex items-center gap-2">
                                <img src="{{ $referenceImage->temporaryUrl() }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200" alt="Preview Referensi">
                                <span class="text-[11px] text-emerald-600 font-medium">Gambar terpilih ✓</span>
                            </div>
                        @endif
                        @error('referenceImage')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Toggle Tingkat B (Custom CSS) --}}
                    <div class="flex flex-col justify-start">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 mb-1">
                            Tingkat B: Kustom CSS Ekstra
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer mt-1">
                            <input type="checkbox" wire:model="allowCustomCss" class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-amber-600"></div>
                            <span class="ml-2 text-xs text-gray-600 dark:text-gray-300 font-medium">
                                Izinkan CSS Tambahan
                            </span>
                        </label>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">
                            AI akan menghasilkan CSS styling scoped. Otomatis disanitasi & diamankan dari ekspresi berbahaya.
                        </p>
                    </div>
                </div>

                {{-- Tombol Generate --}}
                <div class="pt-2 flex items-center justify-between border-t border-gray-100 dark:border-gray-700">
                    <span class="text-[11px] text-gray-500">
                        Diproses di server melalui Laravel Job & Claude API.
                    </span>

                    <button
                        type="button"
                        wire:click="generate"
                        wire:loading.attr="disabled"
                        @if($remainingQuota <= 0) disabled @endif
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-gradient-to-r from-amber-600 to-rose-600 hover:from-amber-700 hover:to-rose-700 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition"
                    >
                        <span wire:loading.remove wire:target="generate" class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            Generate Desain dengan AI
                        </span>
                        <span wire:loading wire:target="generate" class="flex items-center gap-1.5">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Meracik Palet & Desain...
                        </span>
                    </button>
                </div>
            </div>

            {{-- Riwayat Versi Tema (theme_versions) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat Versi Tema ({{ count($versions) }})
                    </h3>
                    <span class="text-xs text-gray-500">
                        Klik untuk melihat pratinjau di iframe
                    </span>
                </div>

                @if($versions->isEmpty())
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400 text-xs bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                        Belum ada versi tema yang di-generate. Masukkan prompt di atas untuk memulai!
                    </div>
                @else
                    <div class="space-y-2.5 max-h-[380px] overflow-y-auto pr-1">
                        @foreach($versions as $ver)
                            <div
                                wire:key="version-{{ $ver->id }}"
                                class="p-3.5 rounded-xl border transition {{ $selectedVersionId === $ver->id ? 'border-amber-500 bg-amber-50/40 dark:bg-amber-950/20 ring-1 ring-amber-400' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800' }}"
                            >
                                <div class="flex items-start justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-xs text-gray-900 dark:text-white">
                                                Versi #{{ $ver->id }}
                                            </span>

                                            @if($ver->status === 'published')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">
                                                    ✓ Aktif / Published
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                    Draft
                                                </span>
                                            @endif

                                            <span class="text-[10px] text-gray-500">
                                                {{ $ver->created_at->diffForHumans() }} ({{ $ver->created_by ?? 'Admin' }})
                                            </span>
                                        </div>

                                        <p class="text-xs text-gray-600 dark:text-gray-300 italic line-clamp-2">
                                            "{{ $ver->prompt ?? 'Tanpa deskripsi' }}"
                                        </p>

                                        {{-- Mini Color Swatches --}}
                                        <div class="flex items-center gap-1.5 pt-1">
                                            <span class="text-[10px] text-gray-500 mr-1">Palet:</span>
                                            <div class="w-4 h-4 rounded-full border border-gray-300 shadow-xs" style="background-color: {{ $ver->theme['color_primary'] ?? '#000' }}" title="Primary"></div>
                                            <div class="w-4 h-4 rounded-full border border-gray-300 shadow-xs" style="background-color: {{ $ver->theme['color_secondary'] ?? '#000' }}" title="Secondary"></div>
                                            <div class="w-4 h-4 rounded-full border border-gray-300 shadow-xs" style="background-color: {{ $ver->theme['color_accent'] ?? '#000' }}" title="Accent"></div>
                                            <div class="w-4 h-4 rounded-full border border-gray-300 shadow-xs" style="background-color: {{ $ver->theme['color_bg'] ?? '#fff' }}" title="Background"></div>
                                            <span class="text-[10px] text-gray-500 ml-2 font-mono">
                                                Template: {{ $ver->theme['template'] ?? 'elegan-floral' }}
                                            </span>
                                            @if(!empty($ver->custom_css))
                                                <span class="text-[10px] px-1.5 py-0.2 rounded bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 font-mono">
                                                    +CSS
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex flex-col gap-1 items-end flex-shrink-0">
                                        <button
                                            type="button"
                                            wire:click="selectVersion({{ $ver->id }})"
                                            class="text-xs px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium transition"
                                        >
                                            👁️ Pratinjau
                                        </button>

                                        @if($ver->status !== 'published')
                                            <button
                                                type="button"
                                                wire:click="applyVersion({{ $ver->id }})"
                                                class="text-xs px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition shadow-xs"
                                            >
                                                ✓ Terapkan
                                            </button>
                                        @endif

                                        <button
                                            type="button"
                                            wire:click="prepareRevision({{ $ver->id }})"
                                            class="text-[11px] px-2 py-0.5 text-sky-600 dark:text-sky-400 hover:underline"
                                        >
                                            ✏️ Revisi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN: PRATINJAU INTERAKTIF DRAFT (5 Kolom) --}}
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                @if($selectedVersion)
                    {{-- Detail Versi Terpilih & Action Bar --}}
                    <div class="space-y-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Pratinjau Draft Aktif
                                </span>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                                    Versi #{{ $selectedVersion->id }}
                                    @if($selectedVersion->status === 'published')
                                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold">
                                            Sedang Digunakan
                                        </span>
                                    @else
                                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold">
                                            Draft Belum Disimpan
                                        </span>
                                    @endif
                                </h4>
                            </div>

                            {{-- Device Simulator Switcher --}}
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 p-0.5 rounded-lg text-xs">
                                <button
                                    type="button"
                                    wire:click="setViewMode('mobile')"
                                    class="px-2 py-1 rounded-md font-semibold transition {{ $viewMode === 'mobile' ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-xs' : 'text-gray-500 hover:text-gray-900' }}"
                                >
                                    📱 HP (390px)
                                </button>
                                <button
                                    type="button"
                                    wire:click="setViewMode('desktop')"
                                    class="px-2 py-1 rounded-md font-semibold transition {{ $viewMode === 'desktop' ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-xs' : 'text-gray-500 hover:text-gray-900' }}"
                                >
                                    💻 Lebar
                                </button>
                            </div>
                        </div>

                        {{-- Attribute Specs --}}
                        <div class="grid grid-cols-2 gap-2 text-[11px] bg-gray-50 dark:bg-gray-900/50 p-2.5 rounded-xl border border-gray-100 dark:border-gray-800">
                            <div>
                                <span class="text-gray-500">Template:</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 ml-1">
                                    {{ $selectedVersion->theme['template'] ?? 'elegan-floral' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500">Efek Bergerak:</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 ml-1">
                                    {{ $selectedVersion->theme['efek_background'] ?? 'petals' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500">Font Judul:</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200 ml-1">
                                    {{ $selectedVersion->theme['font_heading'] ?? '-' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500">Font Isi:</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200 ml-1">
                                    {{ $selectedVersion->theme['font_body'] ?? '-' }}
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Tindakan Cepat (Terapkan / Revisi / Rollback) --}}
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            @if($selectedVersion->status !== 'published')
                                <button
                                    type="button"
                                    wire:click="applyVersion({{ $selectedVersion->id }})"
                                    class="flex-1 inline-flex justify-center items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Terapkan Desain Ini
                                </button>
                            @else
                                <span class="flex-1 text-center py-2 text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 rounded-xl border border-emerald-200 dark:border-emerald-800">
                                    ✓ Sedang Aktif di Undangan
                                </span>
                            @endif

                            <button
                                type="button"
                                wire:click="prepareRevision({{ $selectedVersion->id }})"
                                class="inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-bold text-sky-700 dark:text-sky-300 bg-sky-50 dark:bg-sky-950/40 border border-sky-200 dark:border-sky-800 hover:bg-sky-100 transition"
                            >
                                ✏️ Revisi
                            </button>

                            <a
                                href="{{ route('admin.preview.theme_version', ['version' => $selectedVersion->id]) }}"
                                target="_blank"
                                class="inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 transition"
                                title="Buka di Tab Penuh Baru"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Mockup Bezel HP & Iframe Simulator --}}
                    <div class="mt-4 flex justify-center">
                        <div class="w-full transition-all duration-300 flex justify-center {{ $viewMode === 'mobile' ? 'max-w-[400px]' : 'max-w-full' }}">
                            <div class="w-full bg-gray-900 rounded-[36px] p-3 shadow-2xl border-4 border-gray-800 relative">
                                {{-- Speaker & Camera Notch Simulator --}}
                                <div class="w-28 h-4 bg-gray-800 rounded-full mx-auto mb-2 flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-gray-900"></div>
                                </div>

                                {{-- Iframe Container --}}
                                <div class="w-full bg-white rounded-[24px] overflow-hidden" style="height: 640px;">
                                    <iframe
                                        wire:key="iframe-version-{{ $selectedVersion->id }}"
                                        src="{{ route('admin.preview.theme_version', ['version' => $selectedVersion->id]) }}"
                                        class="w-full h-full border-0"
                                        title="Pratinjau Undangan AI"
                                    ></iframe>
                                </div>

                                {{-- Bottom Home Bar Simulator --}}
                                <div class="w-24 h-1 bg-gray-700 rounded-full mx-auto mt-2"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-20 text-gray-500 dark:text-gray-400 space-y-3">
                        <div class="w-14 h-14 rounded-full bg-amber-100 dark:bg-amber-950/60 text-amber-600 mx-auto flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">
                            Pratinjau Belum Tersedia
                        </h4>
                        <p class="text-xs max-w-xs mx-auto">
                            Tuliskan instruksi tema di kolom kiri lalu klik <strong>Generate Desain dengan AI</strong> untuk melihat hasilnya seketika.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
