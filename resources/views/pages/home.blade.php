@extends('layouts.app')

@section('title', 'Toko Genset Nusantara (V-GEN Jogja) — Genset, Forklift, Lighting Tower')
@section('meta_description', 'Toko Genset Nusantara (V-GEN Jogja) menyediakan genset ready stock 1000W - 2500 KVA, forklift, dan lighting tower dari Yogyakarta ke Semarang, Jakarta, Tangerang, Bandung, Surabaya, Makassar, Bali.')

@section('content')
@php
    $waNumber = \App\Models\Setting::get('whatsapp_number', '6282142458076');
    $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waNumber);
    $heroImgPath = \App\Models\Setting::get('hero_image', 'images/genset-biru-1.jpg');
    $hasHeroReal = file_exists(public_path($heroImgPath));
@endphp

<!-- ========================================================================
     1. HERO SECTION (Min 88vh, Full-bleed, Dark Gradient Overlay Kiri)
     ======================================================================== -->
<section class="hero-section">
    <!-- Background Image atau Fallback Box -->
    @if($hasHeroReal)
        <img src="{{ asset($heroImgPath) }}" alt="Genset V-GEN Jogja di Gudang" class="hero-bg">
    @else
        <div class="hero-bg photo-placeholder" style="border: none; border-radius: 0; background-color: #0B1220; color: rgba(255,255,255,0.35);">
            <span>Foto belum diunggah (public/{{ $heroImgPath }})</span>
        </div>
    @endif

    <!-- Dark gradient overlay di sisi kiri agar teks terbaca -->
    <div class="hero-overlay"></div>

    <div class="container hero-content">
        <div class="hero-main">
            <h1 class="hero-h1">
                Genset ready stock.<br>Kirim ke seluruh Indonesia.
            </h1>
            <p class="hero-sub">
                Genset 1000W sampai 2500 KVA, forklift, dan lighting tower dari Yogyakarta.
            </p>

            <!-- CTA Buttons -->
            <div class="hero-buttons">
                <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                    Lihat Katalog
                </a>
                <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin tanya harga unit ready stock.') }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn btn-white-outline">
                    Tanya Harga via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Inline Metric Row di Dasar Hero dengan Pemisah Garis Tipis Putih -->
    <div class="hero-strip">
        <div class="container">
            <div class="hero-strip-items">
                <div class="hero-strip-item">
                    <span class="hero-strip-num">1000W - 2500 KVA</span>
                    <span class="hero-strip-label">Kapasitas Ready Stock</span>
                </div>
                <div class="hero-strip-divider"></div>
                <div class="hero-strip-item">
                    <span class="hero-strip-num">8 Kota</span>
                    <span class="hero-strip-label">Layanan Pengiriman</span>
                </div>
                <div class="hero-strip-divider"></div>
                <div class="hero-strip-item">
                    <span class="hero-strip-num">6+ Brand</span>
                    <span class="hero-strip-label">Pilihan Mesin</span>
                </div>
                <div class="hero-strip-divider"></div>
                <div class="hero-strip-item">
                    <span class="hero-strip-num">Sejak 2024</span>
                    <span class="hero-strip-label">Toko Genset Nusantara</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================
     2. PRODUK: GRID ASIMETRIS (Genset 7 kol, Forklift & Tower 5 kol)
     ======================================================================== -->
<section class="section" id="produk">
    <div class="container">
        <div style="margin-bottom: 40px;">
            <x-section-heading 
                title="Kategori Produk" 
                subtitle="Unit ready stock siap kirim untuk kebutuhan daya dan operasional Anda."
            />
        </div>

        <div class="asym-grid">
            <!-- Blok Genset Besar (7 Kolom, Tinggi Penuh) -->
            <a href="{{ route('catalog.index', ['kategori' => 'genset']) }}" class="category-card asym-card-main">
                <div style="position: absolute; inset: 0; width: 100%; height: 100%;">
                    <x-image-box 
                        src="images/genset-biru-1.jpg" 
                        alt="Genset V-GEN Ultra Silent dan Open Type" 
                        aspect="auto" 
                        class="cat-img"
                    />
                </div>
                <div class="cat-overlay"></div>
                <div class="cat-content">
                    <span style="display: inline-block; padding: 4px 10px; background-color: var(--yellow); color: var(--ink); font-family: var(--font-heading); font-size: 0.75rem; font-weight: 800; border-radius: 3px; text-transform: uppercase; margin-bottom: 10px;">Ready Stock</span>
                    <h3 class="cat-title">Genset (1000W – 2500 KVA)</h3>
                    <p class="cat-desc">Tersedia tipe silent (kanopi biru V-GEN Ultra Silent) dan open type dari brand Perkins, Cummins, Yanmar, Emerald, Isuzu, Fawde.</p>
                    <span class="cat-action">
                        Lihat Katalog Genset &rarr;
                    </span>
                </div>
            </a>

            <!-- Dua Blok Susun: Forklift & Lighting Tower (5 Kolom) -->
            <div class="asym-stack">
                <!-- Forklift -->
                <a href="{{ route('catalog.index', ['kategori' => 'forklift']) }}" class="category-card asym-card-sub">
                    <div style="position: absolute; inset: 0; width: 100%; height: 100%;">
                        <x-image-box 
                            src="images/forklift-1.jpg" 
                            alt="Forklift Diesel dan Elektrik" 
                            aspect="auto" 
                            class="cat-img"
                        />
                    </div>
                    <div class="cat-overlay"></div>
                    <div class="cat-content">
                        <h3 class="cat-title" style="font-size: 1.45rem;">Forklift</h3>
                        <p class="cat-desc">Unit forklift untuk penanganan muatan gudang, proyek, dan industri.</p>
                        <span class="cat-action">
                            Lihat Unit &rarr;
                        </span>
                    </div>
                </a>

                <!-- Lighting Tower -->
                <a href="{{ route('catalog.index', ['kategori' => 'lighting tower']) }}" class="category-card asym-card-sub">
                    <div style="position: absolute; inset: 0; width: 100%; height: 100%;">
                        <x-image-box 
                            src="images/lighting-tower-1.jpg" 
                            alt="Mobile Lighting Tower" 
                            aspect="auto" 
                            class="cat-img"
                        />
                    </div>
                    <div class="cat-overlay"></div>
                    <div class="cat-content">
                        <h3 class="cat-title" style="font-size: 1.45rem;">Lighting Tower</h3>
                        <p class="cat-desc">Menara penerangan mobile untuk area kerja malam hari, lapangan, dan proyek.</p>
                        <span class="cat-action">
                            Lihat Unit &rarr;
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================
     3. BRAND YANG TERSEDIA
     ======================================================================== -->
<section style="padding: 44px 0; border-top: var(--border-thin); border-bottom: var(--border-thin); background-color: var(--surface);">
    <div class="container">
        <div style="font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted); margin-bottom: 24px; text-align: center;">
            Pilihan Brand Mesin Genset
        </div>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 32px 52px;">
            @foreach($brands as $brand)
                <div style="font-family: var(--font-heading); font-size: 1.3rem; font-weight: 800; color: var(--ink); opacity: 0.9;">
                    {{ $brand->nama }}
                </div>
            @endforeach
            <div style="font-family: var(--font-heading); font-size: 1.15rem; font-weight: 600; color: var(--muted);">
                dan lainnya
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================
     4. KATALOG PREVIEW (PRODUK UNGGULAN READY STOCK)
     ======================================================================== -->
<section class="section">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <x-section-heading 
                title="Unit Ready Stock" 
                subtitle="Contoh pilihan kapasitas genset dan alat berat yang siap dikirim."
            />
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary">
                Buka Katalog Lengkap &rarr;
            </a>
        </div>

        <div class="product-grid">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

<!-- ========================================================================
     5. KENAPA KAMI (3 POIN BERGANTIAN: FOTO 6 KOLOM + TEKS 6 KOLOM)
     ======================================================================== -->
<section class="section" style="background-color: var(--surface); border-top: var(--border-thin); border-bottom: var(--border-thin);">
    <div class="container">
        <div style="margin-bottom: 64px;">
            <x-section-heading 
                title="Kenapa Memilih Kami" 
                subtitle="Fokus kami adalah ketersediaan unit dan kelancaran pengiriman ke lokasi Anda."
            />
        </div>

        <!-- Poin 1: Foto Kiri, Teks Kanan -->
        <div class="reason-row">
            <div class="reason-img-wrap">
                <x-image-box 
                    src="images/gudang-1.jpg" 
                    alt="Gudang Stok Genset V-GEN Jogja" 
                    aspect="16/10" 
                />
            </div>
            <div>
                <span style="font-family: var(--font-heading); font-size: 2.75rem; font-weight: 800; color: var(--line); display: block; line-height: 1; margin-bottom: 8px;">01</span>
                <h3 style="margin-bottom: 16px; font-size: 1.85rem;">Stok Ready di Gudang</h3>
                <p>
                    Kami menyediakan genset ready stock dengan rentang kapasitas mulai dari 1000W hingga 2500 KVA. Ketersediaan unit di gudang siap untuk pengiriman tanpa menunggu waktu inden yang lama.
                </p>
            </div>
        </div>

        <!-- Poin 2: Teks Kiri, Foto Kanan (Reverse) -->
        <div class="reason-row reverse">
            <div class="reason-img-wrap">
                <x-image-box 
                    src="images/genset-biru-2.jpg" 
                    alt="Pilihan Brand Genset di Gudang" 
                    aspect="16/10" 
                />
            </div>
            <div>
                <span style="font-family: var(--font-heading); font-size: 2.75rem; font-weight: 800; color: var(--line); display: block; line-height: 1; margin-bottom: 8px;">02</span>
                <h3 style="margin-bottom: 16px; font-size: 1.85rem;">Banyak Pilihan Brand dan Kapasitas</h3>
                <p>
                    Tersedia berbagai pilihan brand ternama seperti Perkins, Cummins, Yanmar, Emerald, Isuzu, Fawde, dan lainnya, baik tipe silent (kanopi V-GEN) maupun open type untuk kebutuhan proyek, pabrik, perhotelan, atau usaha.
                </p>
            </div>
        </div>

        <!-- Poin 3: Foto Kiri, Teks Kanan -->
        <div class="reason-row">
            <div class="reason-img-wrap">
                <x-image-box 
                    src="images/pengiriman-1.jpg" 
                    alt="Pengiriman Genset ke Kota Layanan" 
                    aspect="16/10" 
                />
            </div>
            <div>
                <span style="font-family: var(--font-heading); font-size: 2.75rem; font-weight: 800; color: var(--line); display: block; line-height: 1; margin-bottom: 8px;">03</span>
                <h3 style="margin-bottom: 16px; font-size: 1.85rem;">Melayani 8 Kota</h3>
                <p>
                    Berpusat di Yogyakarta, jaringan layanan dan pengiriman kami menjangkau Semarang, Jakarta, Tangerang, Bandung, Surabaya, Makassar, dan Bali dengan koordinasi armada yang terencana.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================
     6. GALERI GUDANG & UNIT TERJUAL (Masonry CSS Columns + Vanilla Lightbox)
     ======================================================================== -->
<section class="section">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <x-section-heading 
                title="Galeri Gudang & Unit Terjual" 
                subtitle="Dokumentasi unit ready di gudang, pengiriman forklift, dan genset yang telah terjual."
            />
            <a href="https://instagram.com/tokogensetnusantara" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                Lihat Lebih Banyak di Instagram &rarr;
            </a>
        </div>

        <div class="gallery-masonry">
            @foreach($galleryItems as $item)
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
                        <span style="font-size: 0.8125rem; color: var(--muted); text-transform: uppercase;">{{ ucfirst($item->kategori) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ========================================================================
     7. AREA LAYANAN (Daftar Tipografi 2 Kolom Rapi)
     ======================================================================== -->
<section class="section" id="area-layanan" style="background-color: var(--surface); border-top: var(--border-thin);">
    <div class="container">
        <div style="margin-bottom: 40px;">
            <x-section-heading 
                title="Area Layanan Pengiriman" 
                subtitle="Kami melayani pengiriman unit genset, forklift, dan lighting tower ke kota-kota berikut."
            />
        </div>

        <div class="city-grid">
            @foreach($cities as $city)
                <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin bertanya pengiriman genset ke kota ' . $city) }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="city-link">
                    <span class="city-name">{{ $city }}</span>
                    <span class="city-arrow">Tanya Pengiriman &rarr;</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ========================================================================
     8. CTA AKHIR (Section Gelap --dark)
     ======================================================================== -->
<section class="cta-dark-section">
    <div class="container" style="text-align: center; max-width: 800px;">
        <h2>Butuh genset hari ini?</h2>
        <p>
            Konsultasikan kebutuhan kapasitas daya (1000W - 2500 KVA), ketersediaan tipe silent atau open, dan jadwal pengiriman langsung via WhatsApp.
        </p>
        <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
            <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya butuh informasi unit ready stock.') }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="btn btn-primary" 
               style="font-size: 1.1rem; padding: 0 36px; height: 56px;">
                Hubungi via WhatsApp
            </a>
            <a href="{{ route('catalog.index') }}" 
               class="btn btn-white-outline" 
               style="font-size: 1.1rem; padding: 0 32px; height: 56px;">
                Lihat Katalog Produk
            </a>
        </div>
    </div>
</section>
@endsection
