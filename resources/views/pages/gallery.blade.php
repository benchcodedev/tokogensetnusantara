@extends('layouts.app')

@section('title', 'Galeri Gudang & Unit Terjual — Toko Genset Nusantara (V-GEN Jogja)')
@section('meta_description', 'Dokumentasi gudang genset, forklift, dan unit terjual Toko Genset Nusantara (V-GEN Jogja). Lihat lebih banyak di Instagram @tokogensetnusantara.')

@section('content')
<div class="container section">
    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="breadcrumb-sep">/</span>
        <span style="color: var(--ink); font-weight: 600;">Galeri</span>
    </nav>

    <!-- Header Halaman -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 24px;">
        <div>
            <h1 style="font-size: clamp(2.2rem, 4.5vw, 3.5rem); line-height: 1.1; margin-bottom: 12px;">
                Galeri Gudang &amp; Unit Terjual
            </h1>
            <p style="font-size: 1.15rem; max-width: 700px; color: var(--muted);">
                Dokumentasi stok fisik di gudang Yogyakarta, aktivitas muat barang, unit forklift, dan unit genset yang telah terjual (Sold).
            </p>
        </div>
        <a href="https://instagram.com/tokogensetnusantara" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
            Lihat di Instagram @tokogensetnusantara &rarr;
        </a>
    </div>

    <!-- Filter Tab Kategori (Server-side via Query String) -->
    <div style="display: flex; gap: 12px; margin-bottom: 36px; flex-wrap: wrap; border-bottom: var(--border-thin); padding-bottom: 16px;">
        <a href="{{ route('gallery.index') }}" 
           class="btn btn-sm {{ !request('kategori') ? 'btn-primary' : 'btn-secondary' }}">
            Semua Foto ({{ $counts['semua'] }})
        </a>
        <a href="{{ route('gallery.index', ['kategori' => 'gudang']) }}" 
           class="btn btn-sm {{ request('kategori') == 'gudang' ? 'btn-primary' : 'btn-secondary' }}">
            Gudang / Warehouse ({{ $counts['gudang'] }})
        </a>
        <a href="{{ route('gallery.index', ['kategori' => 'sold']) }}" 
           class="btn btn-sm {{ request('kategori') == 'sold' ? 'btn-primary' : 'btn-secondary' }}">
            Unit Terjual / Sold ({{ $counts['sold'] }})
        </a>
        <a href="{{ route('gallery.index', ['kategori' => 'forklift']) }}" 
           class="btn btn-sm {{ request('kategori') == 'forklift' ? 'btn-primary' : 'btn-secondary' }}">
            Forklift ({{ $counts['forklift'] }})
        </a>
    </div>

    <!-- Masonry Gallery Grid -->
    @if($items->count() > 0)
        <div class="gallery-masonry">
            @foreach($items as $item)
                @php
                    $itemPath = ltrim($item->foto, '/');
                    $itemExists = file_exists(public_path($itemPath));
                @endphp
                <div class="gallery-item" @if($itemExists) data-lightbox-src="{{ asset($itemPath) }}" @endif>
                    @if($itemExists)
                        <img src="{{ asset($itemPath) }}" alt="{{ $item->judul }}" loading="lazy">
                    @else
                        <div class="photo-placeholder" style="aspect-ratio: 4/3;">
                            <span>Foto belum diunggah</span>
                        </div>
                    @endif
                    <div class="gallery-caption">
                        <strong style="display: block;">{{ $item->judul }}</strong>
                        <span style="font-size: 0.8125rem; color: var(--muted); text-transform: uppercase;">
                            {{ ucfirst($item->kategori) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 48px; display: flex; justify-content: center;">
            {{ $items->links() }}
        </div>
    @else
        <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 48px; text-align: center;">
            <p style="color: var(--muted); margin-bottom: 20px;">Belum ada foto dalam kategori ini.</p>
            <a href="{{ route('gallery.index') }}" class="btn btn-primary">Lihat Semua Galeri</a>
        </div>
    @endif
</div>
@endsection
