@extends('admin.layout')

@section('title', $isEdit ? 'Edit Foto Galeri' : 'Unggah Foto Galeri')

@section('content')
<div class="admin-header">
    <div>
        <h1 style="font-size: 2rem; margin-bottom: 4px;">{{ $isEdit ? 'Edit Foto Galeri' : 'Unggah Foto Galeri' }}</h1>
        <p style="font-size: 0.95rem; color: var(--muted);">Dokumentasi untuk ditampilkan di grid masonry beranda.</p>
    </div>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary btn-sm">
        &larr; Kembali ke Daftar Galeri
    </a>
</div>

<div class="admin-card" style="max-width: 700px;">
    <form method="POST" action="{{ $isEdit ? route('admin.gallery.update', $item->id) : route('admin.gallery.store') }}" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="judul" class="form-label">Judul / Keterangan Singkat *</label>
            <input 
                type="text" 
                id="judul" 
                name="judul" 
                value="{{ old('judul', $item->judul) }}" 
                required 
                class="form-control" 
                placeholder="Contoh: Unit V-GEN Ultra Silent 100 KVA Terjual"
            >
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label for="kategori" class="form-label">Kategori Galeri *</label>
                <select id="kategori" name="kategori" required class="form-select">
                    <option value="gudang" {{ old('kategori', $item->kategori) == 'gudang' ? 'selected' : '' }}>Gudang (Warehouse)</option>
                    <option value="sold" {{ old('kategori', $item->kategori) == 'sold' ? 'selected' : '' }}>Sold (Unit Terjual)</option>
                    <option value="forklift" {{ old('kategori', $item->kategori) == 'forklift' ? 'selected' : '' }}>Forklift</option>
                </select>
            </div>

            <div class="form-group">
                <label for="urutan" class="form-label">Urutan Tampil</label>
                <input 
                    type="number" 
                    id="urutan" 
                    name="urutan" 
                    value="{{ old('urutan', $item->urutan ?? 0) }}" 
                    class="form-control" 
                    placeholder="0"
                >
                <div class="form-help">Angka lebih kecil tampil lebih awal.</div>
            </div>
        </div>

        <!-- Foto -->
        <div class="admin-card" style="background-color: var(--bg); padding: 20px; margin-bottom: 24px;">
            <label class="form-label">File Foto</label>
            
            @if($item->foto)
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                    <div style="width: 100px; height: 75px; border-radius: 4px; overflow: hidden; border: var(--border-thin);">
                        <x-image-box :src="$item->foto" :alt="$item->judul" aspect="4/3" />
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; font-weight: 600;">Foto Saat Ini:</div>
                        <div style="font-size: 0.8125rem; color: var(--muted);">{{ $item->foto }}</div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="foto_file" style="font-size: 0.8125rem; font-weight: 600; display: block; margin-bottom: 4px;">
                    Upload File Foto (Simpan ke storage)
                </label>
                <input type="file" id="foto_file" name="foto_file" class="form-control" accept="image/*">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="foto_path" style="font-size: 0.8125rem; font-weight: 600; display: block; margin-bottom: 4px;">
                    Atau Masukkan Path File di public/ (Contoh: images/gudang-1.jpg)
                </label>
                <input 
                    type="text" 
                    id="foto_path" 
                    name="foto_path" 
                    value="{{ old('foto_path', $item->foto) }}" 
                    class="form-control" 
                    placeholder="images/gudang-1.jpg"
                >
            </div>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="height: 50px; padding: 0 32px;">
                {{ $isEdit ? 'Simpan Perubahan' : 'Unggah ke Galeri' }}
            </button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary" style="height: 50px; line-height: 50px; padding: 0 24px;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
