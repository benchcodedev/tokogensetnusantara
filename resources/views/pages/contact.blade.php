@extends('layouts.app')

@section('title', 'Kontak Resmi — Toko Genset Nusantara (V-GEN Jogja)')
@section('meta_description', 'Hubungi Toko Genset Nusantara (V-GEN Jogja) via WhatsApp di +6282142458076 dan Instagram @tokogensetnusantara. Melayani pengiriman ke 8 kota.')

@section('content')
@php
    $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waNumber);
@endphp

<div class="container section">
    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="breadcrumb-sep">/</span>
        <span style="color: var(--ink); font-weight: 600;">Kontak</span>
    </nav>

    <!-- Header Halaman -->
    <div style="margin-bottom: 56px;">
        <h1 style="font-size: clamp(2.2rem, 4.5vw, 3.5rem); line-height: 1.1; margin-bottom: 16px;">
            Kontak Resmi
        </h1>
        <p style="font-size: 1.2rem; max-width: 800px; color: var(--muted);">
            Hubungi kami secara langsung melalui kanal komunikasi resmi di bawah ini untuk konsultasi daya, ketersediaan unit di gudang, dan jadwal pengiriman.
        </p>
    </div>

    <!-- 2 Kolom: Kiri Kanal Kontak, Kanan Info Operasional -->
    <div class="grid-12" style="row-gap: 40px; margin-bottom: 64px;">
        <!-- Kolom Kiri: WhatsApp & Instagram (7 Kolom) -->
        <div style="grid-column: span 7;">
            <!-- WhatsApp Card -->
            <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 36px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 50%; background-color: #25D366; color: #FFFFFF; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm.01 1.67c2.2 0 4.26.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.82c0 4.54-3.7 8.24-8.24 8.24-1.42 0-2.82-.37-4.05-1.07l-.29-.17-3.01.79.8-2.93-.19-.3a8.18 8.18 0 0 1-1.25-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.52 11.64c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.07-.39-2.03-1.25-.75-.67-1.26-1.5-1.4-1.75-.15-.25-.02-.39.11-.51.11-.11.25-.29.38-.44.12-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.12.17 1.77 2.7 4.28 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.11-.23-.17-.48-.29z"/>
                        </svg>
                    </div>
                    <div>
                        <span style="font-size: 0.8125rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;">Layanan Cepat</span>
                        <h2 style="font-size: 1.5rem; margin-top: 2px;">WhatsApp Business</h2>
                    </div>
                </div>

                <p style="font-size: 1rem; color: var(--muted); margin-bottom: 20px;">
                    Nomor Resmi: <strong style="color: var(--ink); font-size: 1.2rem;">+{{ $waNumber }}</strong>
                </p>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin bertanya unit ready stock.') }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn btn-primary" 
                       style="height: 52px; padding: 0 32px;">
                        Buka Obrolan WhatsApp &rarr;
                    </a>
                </div>
            </div>

            <!-- Instagram Card -->
            <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 36px;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 50%; background-color: var(--ink); color: #FFFFFF; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </div>
                    <div>
                        <span style="font-size: 0.8125rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;">Dokumentasi &amp; Video</span>
                        <h2 style="font-size: 1.5rem; margin-top: 2px;">Instagram</h2>
                    </div>
                </div>

                <p style="font-size: 1rem; color: var(--muted); margin-bottom: 20px;">
                    Akun Resmi: <strong style="color: var(--ink); font-size: 1.2rem;">{{ $igHandle }}</strong>
                </p>

                <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="height: 52px; padding: 0 32px;">
                    Kunjungi Instagram &rarr;
                </a>
            </div>
        </div>

        <!-- Kolom Kanan: Info Bisnis & Layanan (5 Kolom) -->
        <div style="grid-column: span 5;">
            <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 36px;">
                <h3 style="font-size: 1.35rem; margin-bottom: 20px; padding-bottom: 12px; border-bottom: var(--border-thin);">
                    Informasi Bisnis
                </h3>

                <div style="margin-bottom: 20px;">
                    <div style="font-size: 0.8125rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;">Nama Usaha</div>
                    <div style="font-weight: 700; color: var(--ink); margin-top: 4px;">Toko Genset Nusantara (V-GEN Jogja)</div>
                </div>

                <div style="margin-bottom: 20px;">
                    <div style="font-size: 0.8125rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;">Berdiri Sejak</div>
                    <div style="font-weight: 700; color: var(--ink); margin-top: 4px;">Tahun 2024</div>
                </div>

                <div style="margin-bottom: 20px;">
                    <div style="font-size: 0.8125rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;">Lokasi Hub Pusat</div>
                    <div style="font-weight: 700; color: var(--ink); margin-top: 4px;">Yogyakarta, Indonesia</div>
                </div>

                <div style="margin-bottom: 24px;">
                    <div style="font-size: 0.8125rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Jangkauan Pengiriman (8 Kota)</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach($cities as $c)
                            <span style="display: inline-block; padding: 4px 10px; background-color: var(--bg); border: var(--border-thin); border-radius: 4px; font-size: 0.875rem; font-weight: 600;">
                                {{ $c }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div style="padding-top: 20px; border-top: var(--border-thin);">
                    <a href="{{ route('catalog.index') }}" class="btn btn-secondary btn-sm" style="width: 100%; text-align: center;">
                        Buka Katalog Produk Ready Stock &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
