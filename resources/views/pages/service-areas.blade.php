@extends('layouts.app')

@section('title', 'Area Layanan Pengiriman Genset — Toko Genset Nusantara')
@section('meta_description', 'Layanan pengiriman unit genset, forklift, dan lighting tower ke Semarang, Yogyakarta, Jakarta, Tangerang, Bandung, Surabaya, Makassar, Bali.')

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
        <span style="color: var(--ink); font-weight: 600;">Area Layanan</span>
    </nav>

    <!-- Header Halaman -->
    <div style="margin-bottom: 56px;">
        <h1 style="font-size: clamp(2.2rem, 4.5vw, 3.5rem); line-height: 1.1; margin-bottom: 16px;">
            Area Layanan Pengiriman
        </h1>
        <p style="font-size: 1.2rem; max-width: 800px; color: var(--muted);">
            Berdiri dan berpusat di Yogyakarta sejak tahun 2024, jaringan pengiriman Toko Genset Nusantara menjangkau 8 kota di Indonesia dengan koordinasi armada yang terencana.
        </p>
    </div>

    <!-- 8 Kota Layanan Cards Grid -->
    <div class="service-cities-grid">
        @foreach($cities as $city)
            <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 28px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 0.8125rem; font-weight: 700; color: var(--blue); text-transform: uppercase; letter-spacing: 0.05em;">
                            Kota Layanan
                        </span>
                        @if($city === 'Yogyakarta')
                            <span style="font-size: 0.75rem; background-color: var(--yellow); color: var(--ink); font-weight: 700; padding: 2px 8px; border-radius: 3px;">
                                Hub Pusat
                            </span>
                        @endif
                    </div>
                    <h3 style="font-size: 1.75rem; margin-bottom: 12px;">{{ $city }}</h3>
                    <p style="font-size: 0.9375rem; color: var(--muted); margin-bottom: 24px;">
                        Pengiriman unit genset (1000W – 2500 KVA), forklift, dan lighting tower langsung ke alamat tujuan di {{ $city }} dan wilayah sekitarnya.
                    </p>
                </div>

                <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin bertanya pengiriman unit ke kota ' . $city) }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn btn-secondary btn-sm" 
                   style="width: 100%; text-align: center;">
                    Tanya Pengiriman ke {{ $city }} &rarr;
                </a>
            </div>
        @endforeach
    </div>

    <!-- Alur Pemesanan & Pengiriman -->
    <div style="background-color: var(--surface); border: var(--border-thin); border-radius: var(--radius-card); padding: 40px; margin-bottom: 48px;">
        <h2 style="font-size: 1.85rem; margin-bottom: 24px;">Alur Pemesanan &amp; Koordinasi Pengiriman</h2>
        <div class="grid-12" style="row-gap: 32px;">
            <div style="grid-column: span 4;">
                <div style="font-family: var(--font-heading); font-size: 2.2rem; font-weight: 800; color: var(--blue); margin-bottom: 8px;">01</div>
                <h4 style="font-size: 1.15rem; margin-bottom: 8px;">Konsultasi Kapasitas Daya</h4>
                <p style="font-size: 0.9375rem; color: var(--muted);">
                    Sampaikan kebutuhan daya listrik usaha atau proyek Anda (1000W sampai 2500 KVA) kepada admin via WhatsApp.
                </p>
            </div>
            <div style="grid-column: span 4;">
                <div style="font-family: var(--font-heading); font-size: 2.2rem; font-weight: 800; color: var(--blue); margin-bottom: 8px;">02</div>
                <h4 style="font-size: 1.15rem; margin-bottom: 8px;">Pengecekan Unit di Gudang</h4>
                <p style="font-size: 0.9375rem; color: var(--muted);">
                    Tim memastikan unit ready stock dari brand pilihan Anda (Perkins, Cummins, Yanmar, Emerald, Isuzu, Fawde) siap dikirim.
                </p>
            </div>
            <div style="grid-column: span 4;">
                <div style="font-family: var(--font-heading); font-size: 2.2rem; font-weight: 800; color: var(--blue); margin-bottom: 8px;">03</div>
                <h4 style="font-size: 1.15rem; margin-bottom: 8px;">Pengiriman ke Kota Tujuan</h4>
                <p style="font-size: 0.9375rem; color: var(--muted);">
                    Unit diberangkatkan dengan armada ekspedisi terpercaya menuju kota Anda dengan konfirmasi jadwal yang jelas.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
