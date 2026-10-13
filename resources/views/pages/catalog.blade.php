@extends('layouts.app')

@section('title', 'Katalog Genset & Alat Berat — Toko Genset Nusantara (V-GEN Jogja)')
@section('meta_description', 'Katalog genset ready stock 1000W sampai 2500 KVA, forklift, dan lighting tower. Pilihan brand Perkins, Cummins, Yanmar, Emerald, Isuzu, Fawde.')

@section('content')
<div class="container section-pad">
    <!-- Header Halaman -->
    <div style="margin-bottom: 32px;">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep">/</span>
            <span style="color: var(--ink); font-weight: 600;">Katalog Produk</span>
        </nav>
        <x-section-heading 
            title="Katalog Produk Ready Stock" 
            subtitle="Pilih berdasarkan kapasitas daya, tipe, atau brand mesin sesuai kebutuhan operasional Anda."
        />
    </div>

    <!-- Filter Bar Server-Side (Query String Form) -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('catalog.index') }}">
            <div class="filter-grid">
                <!-- Pencarian Kata Kunci -->
                <div class="filter-group">
                    <label for="filter-q" class="filter-label">Cari Produk</label>
                    <input 
                        type="text" 
                        id="filter-q" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Contoh: Perkins 50 KVA, Silent..." 
                        class="filter-input"
                    >
                </div>

                <!-- Filter Brand -->
                <div class="filter-group">
                    <label for="filter-brand" class="filter-label">Brand</label>
                    <select id="filter-brand" name="brand" class="filter-select">
                        <option value="">Semua Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->nama }}" {{ request('brand') == $brand->nama ? 'selected' : '' }}>
                                {{ $brand->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Kapasitas -->
                <div class="filter-group">
                    <label for="filter-kapasitas" class="filter-label">Kapasitas</label>
                    <select id="filter-kapasitas" name="kapasitas" class="filter-select">
                        <option value="">Semua Kapasitas</option>
                        <option value="kecil" {{ request('kapasitas') == 'kecil' ? 'selected' : '' }}>Kecil (&lt; 10 KVA / Watt)</option>
                        <option value="menengah" {{ request('kapasitas') == 'menengah' ? 'selected' : '' }}>Menengah (10 – 100 KVA)</option>
                        <option value="besar" {{ request('kapasitas') == 'besar' ? 'selected' : '' }}>Besar (&gt; 100 KVA)</option>
                    </select>
                </div>

                <!-- Filter Tipe -->
                <div class="filter-group">
                    <label for="filter-tipe" class="filter-label">Tipe</label>
                    <select id="filter-tipe" name="tipe" class="filter-select">
                        <option value="">Semua Tipe</option>
                        <option value="silent" {{ request('tipe') == 'silent' ? 'selected' : '' }}>Silent</option>
                        <option value="open" {{ request('tipe') == 'open' ? 'selected' : '' }}>Open</option>
                    </select>
                </div>
            </div>

            <div class="filter-actions">
                @if(request()->hasAny(['q', 'brand', 'kapasitas', 'tipe']))
                    <a href="{{ route('catalog.index') }}" class="btn btn-secondary">
                        Reset Filter
                    </a>
                @endif
                <button type="submit" class="btn btn-primary">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi Jumlah Hasil -->
    <div style="margin-bottom: 24px; font-size: 0.95rem; color: var(--muted); display: flex; justify-content: space-between; align-items: center;">
        <span>Menampilkan <strong>{{ $products->total() }}</strong> unit produk</span>
        @if(request('brand') || request('kapasitas') || request('tipe') || request('q'))
            <span style="font-size: 0.875rem; color: var(--blue);">Filter aktif</span>
        @endif
    </div>

    <!-- Product Grid 3 Kolom Desktop, 2 Tablet, 1 Mobile -->
    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <!-- Pagination Laravel Sederhana -->
        <div style="margin-top: 48px; display: flex; justify-content: center;">
            {{ $products->links() }}
        </div>
    @else
        <!-- State jika tidak ada hasil -->
        <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 48px; text-align: center; margin-top: 24px;">
            <h3 style="margin-bottom: 12px;">Tidak ada produk yang sesuai filter</h3>
            <p style="margin-bottom: 24px; max-width: 480px; margin-left: auto; margin-right: auto;">
                Coba ubah kriteria pencarian atau hubungi kami langsung via WhatsApp untuk pengecekan unit di gudang.
            </p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                Tampilkan Semua Produk
            </a>
        </div>
    @endif
</div>
@endsection
