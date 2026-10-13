@extends('layouts.app')

@section('title', 'Layanan Interior & Custom Furniture — Abadi Jaya Furniture')
@section('meta_description', 'Layanan kontraktor interior & furniture custom mewah: wallpanel, master bedroom, apartemen penthouse, walk-in closet, TV backdrop marmer, dan ruang kantor eksekutif di Jakarta.')

@section('content')

<!-- Header Banner -->
<section class="bg-[#14100A] text-[#F6EFE0] py-20 lg:py-24 border-b border-[#B58A12]/30 text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-xs uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block mb-3">
            Spesialisasi Rancang Bangun
        </span>
        <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-light tracking-tight text-white mb-6">
            Layanan Interior & Furniture Custom
        </h1>
        <div class="w-16 h-0.5 bg-[#C9A24B] mx-auto mb-6"></div>
        <p class="text-sm sm:text-base text-[#F6EFE0]/80 font-light max-w-2xl mx-auto leading-relaxed">
            Menghadirkan harmoni estetika, fungsionalitas cerdas, dan material terbaik untuk setiap sudut hunian pribadi maupun ruang komersial Anda.
        </p>
    </div>
</section>

<!-- Services Grid List -->
<section class="py-20 lg:py-28 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="space-y-16 lg:space-y-24">
            @foreach ($services as $index => $srv)
            @php
                $isReversed = ($index % 2 !== 0);
            @endphp
            <div class="flex flex-col lg:flex-row {{ $isReversed ? 'lg:flex-row-reverse' : '' }} gap-10 lg:gap-14 items-center bg-white p-6 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm hover:border-[#B58A12] transition duration-300">
                
                <!-- Image Container -->
                <div class="w-full lg:w-1/2 overflow-hidden rounded-md h-72 sm:h-96 relative group">
                    <img 
                        src="{{ \App\Services\ImageService::getUrl($srv->cover_image) }}" 
                        alt="{{ $srv->title }}" 
                        loading="lazy" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                </div>

                <!-- Text Content -->
                <div class="w-full lg:w-1/2 flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] uppercase tracking-widest font-semibold text-[#B58A12] block mb-2">
                            Layanan #0{{ $index + 1 }}
                        </span>
                        <h2 class="font-heading text-3xl sm:text-4xl font-normal text-[#1A1308] mb-4">
                            {{ $srv->title }}
                        </h2>
                        <p class="text-sm sm:text-base text-[#1A1308]/75 leading-relaxed font-light mb-6">
                            {{ $srv->short_description }}
                        </p>

                        <!-- Key Benefits / Highlights -->
                        @if (is_array($srv->benefits) && count($srv->benefits) > 0)
                        <div class="mb-8">
                            <h4 class="text-xs uppercase tracking-wider font-semibold text-[#1A1308] mb-3">Keunggulan & Karakter:</h4>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                @foreach (array_slice($srv->benefits, 0, 4) as $ben)
                                <li class="flex items-start text-xs text-[#1A1308]/80">
                                    <svg class="w-4 h-4 text-[#B58A12] mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $ben }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('services.show', $srv->slug) }}" 
                           class="lux-btn-pill bg-[#14100A] text-white hover:bg-[#B58A12] px-7 py-3 text-xs uppercase tracking-wider font-semibold transition">
                            Lihat Rincian & Galeri
                        </a>
                        <a href="https://wa.me/6283872500925?text=Halo%20Abadi%20Jaya%20Furniture,%20saya%20tertarik%20dengan%20layanan%20{{ urlencode($srv->title) }}." 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="lux-btn-pill border border-[#B58A12] text-[#B58A12] hover:bg-[#B58A12] hover:text-white px-6 py-3 text-xs uppercase tracking-wider font-semibold transition flex items-center space-x-2">
                            <span>Konsultasi WA</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
