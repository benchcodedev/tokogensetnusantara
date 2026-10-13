@extends('admin.layout')

@section('title', $isEdit ? 'Edit Produk: ' . $product->nama : 'Tambah Produk Baru')

@section('content')
<div class="admin-header">
    <div>
        <h1 style="font-size: 2rem; margin-bottom: 4px;">{{ $isEdit ? 'Edit Produk' : 'Tambah Produk Baru' }}</h1>
        <p style="font-size: 0.95rem; color: var(--muted);">Lengkapi data unit peralatan di bawah ini.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
        &larr; Kembali ke Daftar Produk
    </a>
</div>

<div class="admin-card" style="max-width: 900px;">
    <form method="POST" action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <!-- Nama Produk & Kategori -->
        <div class="form-row-2">
            <div class="form-group">
                <label for="nama" class="form-label">Nama Produk *</label>
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    value="{{ old('nama', $product->nama) }}" 
                    required 
                    class="form-control" 
                    placeholder="Contoh: Genset Perkins 50 KVA Silent"
                >
            </div>

            <div class="form-group">
                <label for="kategori" class="form-label">Kategori *</label>
                <select id="kategori" name="kategori" required class="form-select">
                    <option value="genset" {{ old('kategori', $product->kategori) == 'genset' ? 'selected' : '' }}>Genset</option>
                    <option value="forklift" {{ old('kategori', $product->kategori) == 'forklift' ? 'selected' : '' }}>Forklift</option>
                    <option value="lighting tower" {{ old('kategori', $product->kategori) == 'lighting tower' ? 'selected' : '' }}>Lighting Tower</option>
                </select>
            </div>
        </div>

        <!-- Brand & Tipe -->
        <div class="form-row-2">
            <div class="form-group">
                <label for="brand" class="form-label">Brand Mesin</label>
                <select id="brand" name="brand" class="form-select">
                    <option value="">-- Pilih Brand atau Kosongkan --</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->nama }}" {{ old('brand', $product->brand) == $b->nama ? 'selected' : '' }}>
                            {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="form-help">Pilihan brand utama: Perkins, Cummins, Yanmar, Emerald, Isuzu, Fawde</div>
            </div>

            <div class="form-group">
                <label for="tipe" class="form-label">Tipe Unit *</label>
                <select id="tipe" name="tipe" required class="form-select">
                    <option value="silent" {{ old('tipe', $product->tipe) == 'silent' ? 'selected' : '' }}>Silent (Kanopi Kedap Suara / Kanopi Biru)</option>
                    <option value="open" {{ old('tipe', $product->tipe) == 'open' ? 'selected' : '' }}>Open Type (Rangka Terbuka)</option>
                </select>
            </div>
        </div>

        <!-- Kapasitas KVA & Label -->
        <div class="form-row-2">
            <div class="form-group">
                <label for="kapasitas_kva" class="form-label">Kapasitas KVA (Angka untuk filter)</label>
                <input 
                    type="number" 
                    step="0.1" 
                    id="kapasitas_kva" 
                    name="kapasitas_kva" 
                    value="{{ old('kapasitas_kva', $product->kapasitas_kva) }}" 
                    class="form-control" 
                    placeholder="Contoh: 50"
                >
                <div class="form-help">Digunakan untuk pengelompokan filter (&lt;10, 10-100, &gt;100 KVA).</div>
            </div>

            <div class="form-group">
                <label for="kapasitas_label" class="form-label">Label Teks Kapasitas</label>
                <input 
                    type="text" 
                    id="kapasitas_label" 
                    name="kapasitas_label" 
                    value="{{ old('kapasitas_label', $product->kapasitas_label) }}" 
                    class="form-control" 
                    placeholder="Contoh: 50 KVA / 40 kW, 3 Ton, dsb."
                >
            </div>
        </div>

        <!-- Deskripsi Singkat -->
        <div class="form-group">
            <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
            <textarea id="deskripsi" name="deskripsi" class="form-textarea" rows="3" placeholder="Deskripsi ringkas unit, kondisi ready stock, dll.">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>

        <!-- Spesifikasi (Baris per Baris) -->
        <div class="form-group">
            <label for="spesifikasi_text" class="form-label">Spesifikasi Detail (Format: Label: Nilai per baris)</label>
            @php
                $specText = '';
                if (!empty($product->spesifikasi) && is_array($product->spesifikasi)) {
                    $lines = [];
                    foreach ($product->spesifikasi as $k => $v) {
                        if (is_numeric($k)) {
                            $lines[] = $v;
                        } else {
                            $lines[] = "{$k}: {$v}";
                        }
                    }
                    $specText = implode("\n", $lines);
                }
            @endphp
            <textarea 
                id="spesifikasi_text" 
                name="spesifikasi_text" 
                class="form-textarea" 
                rows="5" 
                placeholder="Contoh:&#10;Model Engine: Perkins 1103A-33TG1&#10;Alternator: Stamford / Leroy Somer&#10;Kapasitas Tangki: 120 Liter&#10;Dimensi: 2200 x 950 x 1250 mm"
            >{{ old('spesifikasi_text', $specText) }}</textarea>
            <div class="form-help">Satu baris untuk setiap parameter. Pisahkan nama spesifikasi dan isinya dengan titik dua (:).</div>
        </div>

        <!-- Foto Utama -->
        <div class="admin-card" style="background-color: var(--bg); padding: 20px; margin-bottom: 24px;">
            <label class="form-label">Foto Utama Produk</label>
            
            @if($product->foto_utama)
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                    <div style="width: 100px; height: 75px; border-radius: 4px; overflow: hidden; border: var(--border-thin);">
                        <x-image-box :src="$product->foto_utama" :alt="$product->nama" aspect="4/3" />
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; font-weight: 600;">Foto Saat Ini:</div>
                        <div style="font-size: 0.8125rem; color: var(--muted);">{{ $product->foto_utama }}</div>
                    </div>
                </div>
            @endif

            <div class="form-row-2">
                <div>
                    <label for="foto_utama_file" style="font-size: 0.8125rem; font-weight: 600; display: block; margin-bottom: 4px;">
                        Upload Foto Baru (Simpan ke storage)
                    </label>
                    <input type="file" id="foto_utama_file" name="foto_utama_file" class="form-control" accept="image/*">
                </div>

                <div>
                    <label for="foto_utama_path" style="font-size: 0.8125rem; font-weight: 600; display: block; margin-bottom: 4px;">
                        Atau Masukkan Path File di public/ (Contoh: images/genset-biru-1.jpg)
                    </label>
                    <input 
                        type="text" 
                        id="foto_utama_path" 
                        name="foto_utama_path" 
                        value="{{ old('foto_utama_path', $product->foto_utama) }}" 
                        class="form-control" 
                        placeholder="images/genset-biru-1.jpg"
                    >
                </div>
            </div>
            <div class="form-help" style="margin-top: 8px;">
                Jika foto belum ada, sistem akan otomatis menampilkan kotak abu bersih "Foto belum diunggah".
            </div>
        </div>

        <!-- Status & Tampilan -->
        <div style="display: flex; gap: 32px; margin-bottom: 32px; padding-top: 12px; border-top: var(--border-thin);">
            <label class="form-check">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <div>
                    <span style="font-weight: 700; font-size: 0.95rem;">Aktif (Tampilkan di Katalog)</span>
                    <div class="form-help">Unit akan dapat dicari dan dilihat pengunjung.</div>
                </div>
            </label>

            <label class="form-check">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                <div>
                    <span style="font-weight: 700; font-size: 0.95rem;">Produk Unggulan</span>
                    <div class="form-help">Ditampilkan pada halaman depan (Beranda).</div>
                </div>
            </label>
        </div>

        <!-- Submit Buttons -->
        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="height: 50px; padding: 0 32px;">
                {{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Produk' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary" style="height: 50px; line-height: 50px; padding: 0 24px;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
