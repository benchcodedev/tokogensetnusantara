@extends('layouts.app')

@section('title', $product->nama . ' — Toko Genset Nusantara (V-GEN Jogja)')
@section('meta_description', 'Spesifikasi ' . $product->nama . ' kapasitas ' . ($product->kapasitas_label ?: 'ready stock') . ' tipe ' . $product->tipe . '. Hubungi Toko Genset Nusantara untuk ketersediaan unit.')

@section('content')
@php
    $waNumber = \App\Models\Setting::get('whatsapp_number', '6282142458076');
    $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waNumber);
@endphp

<div class="container section-pad">
    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('catalog.index') }}">Katalog</a>
        <span class="breadcrumb-sep">/</span>
        <span style="color: var(--ink); font-weight: 600;">{{ $product->nama }}</span>
    </nav>

    <!-- 2 Kolom: Kiri Foto & Thumbnail, Kanan Spesifikasi & WA -->
    <div class="product-detail-grid">
        <!-- Kolom Foto -->
        <div>
            <div class="product-detail-main-img">
                <x-image-box 
                    :src="$product->foto_utama" 
                    :alt="$product->nama" 
                    aspect="4/3" 
                />
            </div>

            <!-- Galeri Foto Tambahan (Jika Ada) -->
            @if(!empty($product->galeri) && is_array($product->galeri) && count($product->galeri) > 0)
                <div class="product-detail-thumbnails">
                    @foreach($product->galeri as $galeriFoto)
                        <div class="detail-thumb-item">
                            <x-image-box 
                                :src="$galeriFoto" 
                                :alt="$product->nama . ' Thumbnail'" 
                                aspect="4/3" 
                            />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Kolom Info Produk & Tabel Spesifikasi -->
        <div>
            @if($product->brand)
                <div style="font-size: 0.875rem; font-weight: 700; color: var(--blue); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
                    Brand: {{ $product->brand }}
                </div>
            @endif

            <h1 style="font-size: clamp(1.8rem, 3.5vw, 2.5rem); line-height: 1.15; margin-bottom: 16px;">
                {{ $product->nama }}
            </h1>

            <div style="display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap;">
                <span class="badge" style="background-color: var(--surface); border: var(--border-thin); font-size: 0.875rem; padding: 6px 14px;">
                    Kategori: <strong>{{ ucfirst($product->kategori) }}</strong>
                </span>
                <span class="badge" style="background-color: var(--surface); border: var(--border-thin); font-size: 0.875rem; padding: 6px 14px;">
                    Tipe: <strong>{{ ucfirst($product->tipe) }}</strong>
                </span>
                @if($product->kapasitas_label)
                    <span class="badge" style="background-color: var(--surface); border: var(--border-thin); font-size: 0.875rem; padding: 6px 14px;">
                        Kapasitas: <strong>{{ $product->kapasitas_label }}</strong>
                    </span>
                @endif
            </div>

            @if($product->deskripsi)
                <div style="margin-bottom: 24px; font-size: 1.05rem; line-height: 1.6; color: var(--muted);">
                    {{ $product->deskripsi }}
                </div>
            @endif

            <!-- Tabel Spesifikasi Bersih -->
            <h3 style="font-size: 1.25rem; margin-top: 24px; margin-bottom: 8px;">Spesifikasi Unit</h3>
            <div class="spec-table-wrap">
                <table class="spec-table">
                    <tbody>
                        <tr>
                            <th>Brand Engine</th>
                            <td>{{ $product->brand ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kapasitas</th>
                            <td>{{ $product->kapasitas_label ?: ($product->kapasitas_kva ? $product->kapasitas_kva . ' KVA' : '-') }}</td>
                        </tr>
                        <tr>
                            <th>Tipe Kanopi / Rangka</th>
                            <td>{{ ucfirst($product->tipe) }} Type</td>
                        </tr>
                        <tr>
                            <th>Kategori Peralatan</th>
                            <td>{{ ucfirst($product->kategori) }}</td>
                        </tr>

                        @if(!empty($product->spesifikasi) && is_array($product->spesifikasi))
                            @foreach($product->spesifikasi as $key => $val)
                                @if(is_string($val) && !empty($val))
                                    <tr>
                                        <th>{{ is_string($key) ? ucfirst(str_replace('_', ' ', $key)) : 'Spesifikasi' }}</th>
                                        <td>{{ $val }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Tombol Pesan Langsung via WhatsApp -->
            <div style="margin-top: 32px;">
                <a href="{{ $product->getWhatsappInquiryUrl() }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn btn-primary" 
                   style="width: 100%; height: 56px; font-size: 1.1rem; text-align: center;">
                    Tanya Harga Unit via WhatsApp
                </a>
                <p style="font-size: 0.875rem; color: var(--muted); text-align: center; margin-top: 10px;">
                    Respon cepat langsung terhubung dengan admin Toko Genset Nusantara.
                </p>
            </div>
        </div>
    </div>

    <!-- Produk Terkait -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div style="margin-top: 96px; padding-top: 64px; border-top: var(--border-thin);">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 36px; flex-wrap: wrap; gap: 16px;">
                <x-section-heading 
                    title="Produk Terkait" 
                    subtitle="Pilihan unit lain dengan kapasitas atau brand serupa."
                />
                <a href="{{ route('catalog.index') }}" class="btn btn-outline">
                    Semua Produk &rarr;
                </a>
            </div>

            <div class="product-grid">
                @foreach($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
