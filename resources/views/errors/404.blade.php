@extends('layouts.app')

@section('title', '404 — Halaman Tidak Ditemukan | Toko Genset Nusantara')
@section('meta_description', 'Halaman tidak ditemukan di Toko Genset Nusantara (V-GEN Jogja). Silakan kembali ke katalog genset ready stock.')

@section('content')
<section class="section" style="min-height: 70vh; display: flex; align-items: center; justify-content: center; text-align: center;">
    <div class="container" style="max-width: 600px;">
        <span style="font-family: var(--font-heading); font-size: clamp(4rem, 12vw, 6.5rem); font-weight: 800; color: var(--blue); line-height: 1; display: block; margin-bottom: 12px;">
            404
        </span>
        <h1 style="font-size: clamp(1.8rem, 4vw, 2.4rem); margin-bottom: 16px;">
            Halaman Tidak Ditemukan
        </h1>
        <p style="font-size: 1.0625rem; color: var(--muted); margin-bottom: 32px; line-height: 1.6;">
            Halaman yang Anda tuju mungkin telah dipindahkan atau alamat URL tidak sesuai. Silakan kembali ke katalog produk ready stock kami.
        </p>
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn btn-secondary">
                Kembali ke Beranda
            </a>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                Lihat Katalog Genset
            </a>
        </div>
    </div>
</section>
@endsection
