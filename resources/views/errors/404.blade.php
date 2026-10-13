@extends('layouts.app')

@section('title', '404 — Halaman Tidak Ditemukan | Abadi Jaya Furniture')

@section('content')
<section class="bg-[#14100A] text-[#F6EFE0] min-h-[70vh] flex items-center justify-center py-20 px-4 text-center">
    <div class="max-w-md mx-auto space-y-6">
        <span class="font-heading text-8xl sm:text-9xl font-light text-[#C9A24B] block tracking-tighter">
            404
        </span>
        <h1 class="font-heading text-2xl sm:text-3xl font-light text-white">
            Halaman Tidak Ditemukan
        </h1>
        <div class="w-12 h-0.5 bg-[#C9A24B] mx-auto"></div>
        <p class="text-xs sm:text-sm text-[#F6EFE0]/70 font-light leading-relaxed">
            Halaman yang Anda tuju mungkin telah dipindahkan atau tautan tidak valid. Silakan kembali ke beranda untuk mengeksplorasi koleksi interior kami.
        </p>
        <div class="pt-4">
            <a href="{{ route('home') }}" class="lux-btn-pill bg-[#B58A12] text-white hover:bg-[#8F6309] px-8 py-3.5 text-xs uppercase tracking-widest font-semibold transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection
