@extends('admin.layout')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="admin-header">
    <div>
        <h1 style="font-size: 2rem; margin-bottom: 4px;">Pengaturan Toko</h1>
        <p style="font-size: 0.95rem; color: var(--muted);">Kelola kontak resmi WhatsApp, Instagram, dan teks banner hero.</p>
    </div>
</div>

<div class="admin-card" style="max-width: 800px;">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <h2 style="font-size: 1.25rem; margin-bottom: 20px; padding-bottom: 12px; border-bottom: var(--border-thin);">
            Kontak Resmi &amp; Media Sosial
        </h2>

        <div class="form-group">
            <label for="whatsapp_number" class="form-label">Nomor WhatsApp *</label>
            <input 
                type="text" 
                id="whatsapp_number" 
                name="whatsapp_number" 
                value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}" 
                required 
                class="form-control" 
                placeholder="6282142458076"
            >
            <div class="form-help">Format angka dengan kode negara 62 tanpa spasi atau tanda tambah (+). Digunakan untuk semua link otomatis wa.me.</div>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label for="instagram_url" class="form-label">URL Profil Instagram *</label>
                <input 
                    type="url" 
                    id="instagram_url" 
                    name="instagram_url" 
                    value="{{ old('instagram_url', $settings['instagram_url']) }}" 
                    required 
                    class="form-control" 
                    placeholder="https://instagram.com/tokogensetnusantara"
                >
            </div>

            <div class="form-group">
                <label for="instagram_handle" class="form-label">Username / Handle Instagram *</label>
                <input 
                    type="text" 
                    id="instagram_handle" 
                    name="instagram_handle" 
                    value="{{ old('instagram_handle', $settings['instagram_handle']) }}" 
                    required 
                    class="form-control" 
                    placeholder="@tokogensetnusantara"
                >
            </div>
        </div>

        <h2 style="font-size: 1.25rem; margin-top: 36px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: var(--border-thin);">
            Teks Banner Utama (Hero Beranda)
        </h2>

        <div class="form-group">
            <label for="hero_headline" class="form-label">Headline Hero *</label>
            <input 
                type="text" 
                id="hero_headline" 
                name="hero_headline" 
                value="{{ old('hero_headline', $settings['hero_headline']) }}" 
                required 
                class="form-control" 
                placeholder="Genset ready stock. Kirim ke seluruh Indonesia."
            >
        </div>

        <div class="form-group">
            <label for="hero_subheadline" class="form-label">Subheadline Hero *</label>
            <textarea 
                id="hero_subheadline" 
                name="hero_subheadline" 
                required 
                class="form-textarea" 
                rows="2"
            >{{ old('hero_subheadline', $settings['hero_subheadline']) }}</textarea>
        </div>

        <div class="admin-card" style="background-color: var(--bg); padding: 20px; margin-bottom: 28px;">
            <label class="form-label">Foto Latar Hero (Genset di Gudang)</label>

            @if($settings['hero_image'])
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                    <div style="width: 120px; height: 68px; border-radius: 4px; overflow: hidden; border: var(--border-thin);">
                        <x-image-box :src="$settings['hero_image']" alt="Hero background" aspect="16/9" />
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; font-weight: 600;">Foto Saat Ini:</div>
                        <div style="font-size: 0.8125rem; color: var(--muted);">{{ $settings['hero_image'] }}</div>
                    </div>
                </div>
            @endif

            <div class="form-row-2">
                <div>
                    <label for="hero_image_file" style="font-size: 0.8125rem; font-weight: 600; display: block; margin-bottom: 4px;">
                        Upload Foto Hero Baru
                    </label>
                    <input type="file" id="hero_image_file" name="hero_image_file" class="form-control" accept="image/*">
                </div>

                <div>
                    <label for="hero_image_path" style="font-size: 0.8125rem; font-weight: 600; display: block; margin-bottom: 4px;">
                        Atau Path File di public/
                    </label>
                    <input 
                        type="text" 
                        id="hero_image_path" 
                        name="hero_image_path" 
                        value="{{ old('hero_image_path', $settings['hero_image']) }}" 
                        class="form-control" 
                        placeholder="images/genset-biru-1.jpg"
                    >
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="height: 50px; padding: 0 36px;">
            Simpan Semua Pengaturan
        </button>
    </form>
</div>
@endsection
