@extends('layouts.app')

@section('title', 'Lokasi Showroom Resmi — Abadi Jaya Furniture Jakarta')
@section('meta_description', 'Kunjungi 3 showroom resmi Abadi Jaya Furniture di Pondok Indah Mall 1 (GF 017 & 022), Pondok Indah Mall 2 (B1 05-06), dan Ruko Boston PIK 2.')

@section('content')

<!-- Header Banner -->
<section class="bg-[#14100A] text-[#F6EFE0] py-20 lg:py-24 border-b border-[#B58A12]/30 text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-xs uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block mb-3">
            Experience Centers Jakarta
        </span>
        <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-light tracking-tight text-white mb-6">
            Showroom Resmi Kami
        </h1>
        <div class="w-16 h-0.5 bg-[#C9A24B] mx-auto mb-6"></div>
        <p class="text-sm sm:text-base text-[#F6EFE0]/80 font-light max-w-2xl mx-auto leading-relaxed">
            Hadir di pusat gaya hidup Jakarta Selatan dan Jakarta Utara untuk memudahkan Anda mengeksplorasi material fisik, mock-up interior, dan berkonsultasi langsung.
        </p>
    </div>
</section>

<!-- Showrooms List -->
<section class="py-20 lg:py-28 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="space-y-16 lg:space-y-24">
            @foreach ($showrooms as $index => $shw)
            @php
                $isReversed = ($index % 2 !== 0);
            @endphp
            <div class="bg-white rounded-md overflow-hidden border border-[#B58A12]/20 shadow-sm hover:border-[#B58A12] transition duration-300 p-6 sm:p-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left: Details & Directions -->
                    <div class="{{ $isReversed ? 'lg:order-2' : '' }} flex flex-col justify-between space-y-6">
                        <div>
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="bg-[#B58A12] text-white text-[10px] uppercase tracking-widest font-semibold px-3 py-1 rounded-full">
                                    {{ $shw->city }}
                                </span>
                                <span class="text-xs text-gray-400 font-light">Lokasi #0{{ $index + 1 }}</span>
                            </div>

                            <h2 class="font-heading text-3xl sm:text-4xl font-normal text-[#1A1308] mb-2">
                                {{ $shw->name }}
                            </h2>
                            <p class="text-sm font-semibold text-[#B58A12] mb-6">
                                {{ $shw->floor_unit }}
                            </p>

                            <div class="space-y-4 text-xs sm:text-sm text-[#1A1308]/80 font-light">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-[#B58A12] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <div>
                                        <strong class="font-medium text-[#1A1308] block mb-0.5">Alamat Lengkap:</strong>
                                        <p>{{ $shw->address }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-[#B58A12] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <div>
                                        <strong class="font-medium text-[#1A1308] block mb-0.5">Jam Operasional:</strong>
                                        <p>{{ $shw->opening_hours }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-[#B58A12] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <div>
                                        <strong class="font-medium text-[#1A1308] block mb-0.5">Kontak Showroom:</strong>
                                        <p>{{ $shw->phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="pt-6 border-t border-gray-100 flex flex-wrap gap-4">
                            <a href="{{ $shw->gmaps_link ?: 'https://maps.google.com' }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="lux-btn-pill bg-[#14100A] text-white hover:bg-[#B58A12] px-7 py-3 text-xs uppercase tracking-wider font-semibold transition flex items-center space-x-2">
                                <svg class="w-4 h-4 text-[#C9A24B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Petunjuk Arah Google Maps</span>
                            </a>
                            <a href="https://wa.me/6283872500925?text=Halo%20Abadi%20Jaya,%20saya%20ingin%20jadwalkan%20kunjungan%20ke%20showroom%20{{ urlencode($shw->name) }}." 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="lux-btn-pill border border-[#B58A12] text-[#B58A12] hover:bg-[#B58A12] hover:text-white px-6 py-3 text-xs uppercase tracking-wider font-semibold transition flex items-center space-x-2">
                                <span>Janji Temu via WA</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Google Maps Embed or Image -->
                    <div class="{{ $isReversed ? 'lg:order-1' : '' }} space-y-4">
                        @if ($shw->gmaps_embed)
                        <div class="aspect-[4/3] rounded-md overflow-hidden bg-gray-100 border border-gray-200 shadow-inner">
                            <iframe src="{{ $shw->gmaps_embed }}" class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                        @else
                        <div class="aspect-[4/3] rounded-md overflow-hidden bg-black/10">
                            <img src="{{ \App\Services\ImageService::getUrl($shw->image) }}" alt="{{ $shw->name }}" class="w-full h-full object-cover">
                        </div>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
