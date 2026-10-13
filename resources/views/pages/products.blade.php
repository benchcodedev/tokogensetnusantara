@extends('layouts.app')

@section('title', 'Produk Genset, Forklift & Lighting Tower — Toko Genset Nusantara')
@section('meta_description', 'Pilihan produk ready stock dari Toko Genset Nusantara (V-GEN Jogja): genset kapasitas 1000W hingga 2500 KVA, forklift, dan lighting tower.')

@section('content')
@php
    $waNumber = \App\Models\Setting::get('whatsapp_number', '6282142458076');
    $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waNumber);
@endphp

<div class="container section">
    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="breadcrumb-sep">/</span>
        <span style="color: var(--ink); font-weight: 600;">Produk</span>
    </nav>

    <!-- Header Halaman -->
    <div style="margin-bottom: 56px;">
        <h1 style="font-size: clamp(2.2rem, 4.5vw, 3.5rem); line-height: 1.1; margin-bottom: 16px;">
            Pilihan Produk &amp; Peralatan
        </h1>
        <p style="font-size: 1.2rem; max-width: 800px; color: var(--muted);">
            Toko Genset Nusantara menyediakan 3 lini peralatan ready stock: unit genset kapasitas 1000W sampai 2500 KVA, forklift untuk penanganan muatan, dan lighting tower untuk penerangan lapangan.
        </p>
    </div>

    <!-- 1. KATEGORI GENSET -->
    <div id="genset" style="margin-bottom: 88px; padding-bottom: 72px; border-bottom: var(--border-thin);">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; flex-wrap: wrap; gap: 20px;">
            <div>
                <span style="font-size: 0.8125rem; font-weight: 700; color: var(--blue); text-transform: uppercase; letter-spacing: 0.08em; display: block; margin-bottom: 6px;">
                    Lini Utama
                </span>
                <h2 style="font-size: 2.2rem;">Genset Ready Stock (1000W – 2500 KVA)</h2>
            </div>
            <a href="{{ route('catalog.index', ['kategori' => 'genset']) }}" class="btn btn-primary">
                Buka Katalog Genset Lengkap &rarr;
            </a>
        </div>

        <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 32px; margin-bottom: 40px;">
            <div class="grid-12" style="row-gap: 24px;">
                <div style="grid-column: span 6;">
                    <h3 style="font-size: 1.35rem; margin-bottom: 12px; color: var(--blue);">
                        V-GEN Ultra Silent (Kanopi Biru)
                    </h3>
                    <p style="font-size: 0.95rem; line-height: 1.6; color: var(--muted);">
                        Genset tipe silent dilengkapi kanopi khusus berwarna biru khas V-GEN dengan peredam suara. Cocok untuk lingkungan yang membutuhkan tingkat kebisingan rendah seperti rumah sakit, perhotelan, ruko komersial, kantor, dan kafe.
                    </p>
                </div>
                <div style="grid-column: span 6;">
                    <h3 style="font-size: 1.35rem; margin-bottom: 12px; color: var(--ink);">
                        Open Type (Rangka Terbuka)
                    </h3>
                    <p style="font-size: 0.95rem; line-height: 1.6; color: var(--muted);">
                        Genset tipe open dirancang untuk pemasangan di ruang genset khusus (power house) pada pabrik, area pertambangan, atau proyek konstruksi luar ruangan dengan ventilasi sirkulasi udara bebas.
                    </p>
                </div>
            </div>
            <div style="margin-top: 24px; padding-top: 20px; border-top: var(--border-thin); display: flex; flex-wrap: wrap; gap: 16px; align-items: center;">
                <strong style="font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--ink);">Pilihan Brand:</strong>
                @foreach($brands as $b)
                    <span style="font-weight: 700; font-size: 0.95rem; color: var(--ink);">{{ $b->nama }}</span>
                    @if(!$loop->last) <span style="color: var(--line);">&bull;</span> @endif
                @endforeach
                <span style="color: var(--muted); font-size: 0.95rem;">dan lainnya</span>
            </div>
        </div>

        <!-- Contoh Produk Genset -->
        <div class="product-grid">
            @foreach($gensetProducts as $p)
                <x-product-card :product="$p" />
            @endforeach
        </div>
    </div>

    <!-- 2. KATEGORI FORKLIFT -->
    <div id="forklift" style="margin-bottom: 88px; padding-bottom: 72px; border-bottom: var(--border-thin);">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; flex-wrap: wrap; gap: 20px;">
            <div>
                <span style="font-size: 0.8125rem; font-weight: 700; color: var(--blue); text-transform: uppercase; letter-spacing: 0.08em; display: block; margin-bottom: 6px;">
                    Material Handling
                </span>
                <h2 style="font-size: 2.2rem;">Forklift</h2>
            </div>
            <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin bertanya stok unit Forklift.') }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="btn btn-secondary">
                Tanya Stok Forklift via WhatsApp &rarr;
            </a>
        </div>

        <p style="max-width: 800px; margin-bottom: 32px; font-size: 1.05rem;">
            Unit forklift untuk menunjang bongkar muat logistik gudang, pabrik, dan proyek lapangan. Tersedia berbagai pilihan kapasitas angkat yang siap dikirim ke lokasi kerja Anda.
        </p>

        @if($forkliftProducts->count() > 0)
            <div class="product-grid">
                @foreach($forkliftProducts as $p)
                    <x-product-card :product="$p" />
                @endforeach
            </div>
        @else
            <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 32px; text-align: center;">
                <p>Silakan hubungi WhatsApp kami untuk informasi ketersediaan unit forklift ready stock.</p>
            </div>
        @endif
    </div>

    <!-- 3. KATEGORI LIGHTING TOWER -->
    <div id="lighting-tower" style="margin-bottom: 64px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; flex-wrap: wrap; gap: 20px;">
            <div>
                <span style="font-size: 0.8125rem; font-weight: 700; color: var(--blue); text-transform: uppercase; letter-spacing: 0.08em; display: block; margin-bottom: 6px;">
                    Mobile Penerangan
                </span>
                <h2 style="font-size: 2.2rem;">Lighting Tower</h2>
            </div>
            <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin bertanya stok unit Lighting Tower.') }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="btn btn-secondary">
                Tanya Stok Lighting Tower &rarr;
            </a>
        </div>

        <p style="max-width: 800px; margin-bottom: 32px; font-size: 1.05rem;">
            Menara lampu sorot mobile dengan generator terintegrasi, dirancang khusus untuk penerangan kerja lembur malam hari, area konstruksi, tambang, perbaikan jalan, maupun kegiatan lapangan terbuka.
        </p>

        @if($towerProducts->count() > 0)
            <div class="product-grid">
                @foreach($towerProducts as $p)
                    <x-product-card :product="$p" />
                @endforeach
            </div>
        @else
            <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 32px; text-align: center;">
                <p>Hubungi kontak WhatsApp untuk menanyakan spesifikasi unit lighting tower yang tersedia.</p>
            </div>
        @endif
    </div>
</div>
@endsection
