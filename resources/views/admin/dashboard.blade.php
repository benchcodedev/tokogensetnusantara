@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="admin-header">
    <div>
        <h1 style="font-size: 2rem; margin-bottom: 4px;">Dashboard Ringkasan</h1>
        <p style="font-size: 0.95rem; color: var(--muted);">Status katalog dan aset Toko Genset Nusantara.</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
            + Tambah Produk Baru
        </a>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-secondary btn-sm">
            + Unggah Foto Galeri
        </a>
    </div>
</div>

<!-- Metric Cards Grid -->
<div class="admin-metrics-grid">
    <div class="admin-metric-card">
        <div class="admin-metric-lbl">Total Produk</div>
        <div class="admin-metric-val">{{ $metrics['total_products'] }}</div>
        <div style="font-size: 0.8125rem; color: var(--muted); margin-top: 4px;">
            {{ $metrics['active_products'] }} aktif di katalog
        </div>
    </div>

    <div class="admin-metric-card">
        <div class="admin-metric-lbl">Foto Galeri</div>
        <div class="admin-metric-val">{{ $metrics['total_gallery'] }}</div>
        <div style="font-size: 0.8125rem; color: var(--muted); margin-top: 4px;">
            Dokumentasi gudang &amp; sold
        </div>
    </div>

    <div class="admin-metric-card">
        <div class="admin-metric-lbl">Brand Terdaftar</div>
        <div class="admin-metric-val">{{ $metrics['total_brands'] }}</div>
        <div style="font-size: 0.8125rem; color: var(--muted); margin-top: 4px;">
            Perkins, Cummins, Yanmar, dll.
        </div>
    </div>

    <div class="admin-metric-card">
        <div class="admin-metric-lbl">Kota Layanan</div>
        <div class="admin-metric-val">8</div>
        <div style="font-size: 0.8125rem; color: var(--muted); margin-top: 4px;">
            Yogyakarta, Jakarta, Surabaya, dll.
        </div>
    </div>
</div>

<!-- Produk Terbaru -->
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 1.35rem;">Produk Terbaru</h2>
        <a href="{{ route('admin.products.index') }}" style="font-size: 0.875rem; font-weight: 600;">
            Lihat Semua Produk &rarr;
        </a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Brand</th>
                    <th>Kapasitas</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentProducts as $prod)
                    <tr>
                        <td style="width: 70px;">
                            <div style="width: 60px; height: 45px; border-radius: 4px; overflow: hidden; border: var(--border-thin);">
                                <x-image-box :src="$prod->foto_utama" :alt="$prod->nama" aspect="4/3" />
                            </div>
                        </td>
                        <td>
                            <strong>{{ $prod->nama }}</strong>
                            <div style="font-size: 0.75rem; color: var(--muted);">{{ ucfirst($prod->kategori) }}</div>
                        </td>
                        <td>{{ $prod->brand ?: '-' }}</td>
                        <td>{{ $prod->kapasitas_label ?: '-' }}</td>
                        <td>{{ ucfirst($prod->tipe) }}</td>
                        <td>
                            @if($prod->is_active)
                                <span class="admin-badge admin-badge-success">Aktif</span>
                            @else
                                <span class="admin-badge admin-badge-muted">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $prod->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--muted); padding: 24px;">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Galeri Terbaru -->
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 1.35rem;">Dokumentasi Galeri Terbaru</h2>
        <a href="{{ route('admin.gallery.index') }}" style="font-size: 0.875rem; font-weight: 600;">
            Kelola Galeri &rarr;
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px;">
        @forelse($recentGallery as $gal)
            <div style="border: var(--border-thin); border-radius: var(--radius-card); overflow: hidden; background-color: var(--bg);">
                <div style="aspect-ratio: 4/3; overflow: hidden;">
                    <x-image-box :src="$gal->foto" :alt="$gal->judul" aspect="4/3" />
                </div>
                <div style="padding: 10px;">
                    <div style="font-size: 0.875rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $gal->judul }}
                    </div>
                    <div style="font-size: 0.75rem; color: var(--muted); text-transform: uppercase;">
                        {{ $gal->kategori }}
                    </div>
                </div>
            </div>
        @empty
            <p style="color: var(--muted);">Belum ada item galeri.</p>
        @endforelse
    </div>
</div>
@endsection
