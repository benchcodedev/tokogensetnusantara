@extends('admin.layout')

@section('title', 'Kelola Produk')

@section('content')
<div class="admin-header">
    <div>
        <h1 style="font-size: 2rem; margin-bottom: 4px;">Katalog Produk</h1>
        <p style="font-size: 0.95rem; color: var(--muted);">Daftar unit genset, forklift, dan lighting tower.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        + Tambah Produk Baru
    </a>
</div>

<!-- Filter Bar Sederhana -->
<div class="admin-card" style="padding: 16px 24px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.products.index') }}" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: center;">
        <input 
            type="text" 
            name="q" 
            value="{{ request('q') }}" 
            placeholder="Cari nama atau brand..." 
            class="form-control" 
            style="max-width: 280px;"
        >
        <select name="brand" class="form-select" style="max-width: 200px;">
            <option value="">Semua Brand</option>
            @foreach($brands as $b)
                <option value="{{ $b->nama }}" {{ request('brand') == $b->nama ? 'selected' : '' }}>{{ $b->nama }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        @if(request('q') || request('brand'))
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        @endif
    </form>
</div>

<!-- Tabel Produk -->
<div class="admin-card" style="padding: 0; overflow: hidden;">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Foto</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Brand</th>
                    <th>Kapasitas</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $prod)
                    <tr>
                        <td>
                            <div style="width: 64px; height: 48px; border-radius: 4px; overflow: hidden; border: var(--border-thin);">
                                <x-image-box :src="$prod->foto_utama" :alt="$prod->nama" aspect="4/3" />
                            </div>
                        </td>
                        <td>
                            <strong>{{ $prod->nama }}</strong>
                            @if($prod->is_featured)
                                <span class="admin-badge admin-badge-blue" style="margin-left: 6px;">Unggulan</span>
                            @endif
                            <div style="font-size: 0.8125rem; color: var(--muted); margin-top: 2px;">
                                slug: {{ $prod->slug }}
                            </div>
                        </td>
                        <td>{{ ucfirst($prod->kategori) }}</td>
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
                        <td style="text-align: right; white-space: nowrap;">
                            <a href="{{ route('product.show', $prod->slug) }}" target="_blank" class="btn btn-secondary btn-sm" style="margin-right: 6px;" title="Lihat di Web">
                                Preview
                            </a>
                            <a href="{{ route('admin.products.edit', $prod->id) }}" class="btn btn-secondary btn-sm" style="margin-right: 6px;">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $prod->id) }}" style="display: inline-block;" onsubmit="return confirm('Hapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--muted); padding: 36px;">
                            Tidak ada produk yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 24px; display: flex; justify-content: center;">
    {{ $products->links() }}
</div>
@endsection
