@extends('layouts.app')

@section('title', $service->title . ' — Abadi Jaya Furniture Jakarta')
@section('meta_description', $service->short_description)

@section('content')

<!-- Header Banner -->
<section class="relative h-[45vh] min-h-[360px] bg-[#14100A] text-white flex items-center justify-center overflow-hidden">
    <img 
        src="{{ \App\Services\ImageService::getUrl($service->cover_image) }}" 
        alt="{{ $service->title }}" 
        class="absolute inset-0 w-full h-full object-cover opacity-35"
        fetchpriority="high"
    />
    <div class="absolute inset-0 bg-gradient-to-t from-[#14100A] via-black/40 to-transparent"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <a href="{{ route('services.index') }}" class="inline-flex items-center space-x-2 text-xs uppercase tracking-widest text-[#C9A24B] hover:text-white mb-4 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Semua Layanan</span>
        </a>
        <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-light text-white tracking-tight">
            {{ $service->title }}
        </h1>
        <div class="w-16 h-0.5 bg-[#C9A24B] mx-auto mt-4"></div>
    </div>
</section>

<!-- Main Details -->
<section class="py-16 lg:py-24 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">
            
            <!-- Left 2 Cols: Description, Materials & Gallery -->
            <div class="lg:col-span-2 space-y-12">
                
                <!-- Overview -->
                <div class="bg-white p-8 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-6">
                        Deskripsi & Filosofi Desain
                    </h2>
                    <div class="prose prose-stone max-w-none text-sm sm:text-base text-[#1A1308]/80 leading-relaxed font-light space-y-4">
                        <p class="text-lg font-normal text-[#B58A12] leading-relaxed">
                            {{ $service->short_description }}
                        </p>
                        <p>
                            {{ $service->full_description }}
                        </p>
                    </div>
                </div>

                <!-- Materials & Specifications -->
                @if ($service->materials_used)
                <div class="bg-white p-8 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-4">
                        Spesifikasi Material & Finishing
                    </h2>
                    <div class="w-12 h-0.5 bg-[#B58A12] mb-6"></div>
                    <p class="text-sm sm:text-base text-[#1A1308]/80 leading-relaxed font-light bg-[#FAF7F2] p-6 rounded-md border-l-4 border-[#B58A12]">
                        {{ $service->materials_used }}
                    </p>
                </div>
                @endif

                <!-- Benefits Checklist -->
                @if (is_array($service->benefits) && count($service->benefits) > 0)
                <div class="bg-white p-8 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-6">
                        Nilai Tambah & Keunggulan
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($service->benefits as $ben)
                        <div class="flex items-start space-x-3 p-3.5 rounded-md bg-[#FAF7F2]/80">
                            <svg class="w-5 h-5 text-[#B58A12] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-xs sm:text-sm text-[#1A1308]/90 font-medium">{{ $ben }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Gallery Showcase (Lightbox) -->
                @if (is_array($service->gallery_images) && count($service->gallery_images) > 0)
                <div class="bg-white p-8 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-6">
                        Galeri Contoh Pengerjaan
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        @foreach ($service->gallery_images as $img)
                        <div class="relative aspect-video rounded-md overflow-hidden bg-black/10 group">
                            <img src="{{ \App\Services\ImageService::getUrl($img) }}" alt="{{ $service->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <a href="{{ \App\Services\ImageService::getUrl($img) }}" 
                               class="glightbox absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white"
                               data-gallery="service-gallery"
                               data-title="{{ $service->title }}">
                                <span class="bg-white/20 backdrop-blur-md p-3 rounded-full hover:bg-white hover:text-black transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                </span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <!-- Right 1 Col: Quick Consultation Sticky Card -->
            <div class="space-y-8">
                
                <!-- CTA Card -->
                <div class="sticky top-28 bg-[#14100A] text-white p-8 sm:p-9 rounded-md border border-[#B58A12]/40 shadow-xl">
                    <span class="text-xs uppercase tracking-widest text-[#C9A24B] font-semibold block mb-2">
                        Konsultasi Khusus
                    </span>
                    <h3 class="font-heading text-2xl font-normal text-white mb-4">
                        Tertarik dengan Layanan Ini?
                    </h3>
                    <p class="text-xs sm:text-sm text-[#F6EFE0]/80 font-light leading-relaxed mb-6">
                        Diskusikan kebutuhan spesifik ruangan Anda dengan tim arsitek interior kami. Dapatkan penawaran awal dan jadwalkan kunjungan showroom.
                    </p>

                    <a href="https://wa.me/6283872500925?text=Halo%20Abadi%20Jaya%20Furniture,%20saya%20tertarik%20dengan%20layanan%20{{ urlencode($service->title) }}." 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="lux-btn-pill w-full bg-[#B58A12] text-white hover:bg-[#8F6309] py-3.5 text-xs uppercase tracking-wider font-semibold transition mb-3">
                        Konsultasi via WhatsApp
                    </a>

                    <a href="{{ route('contact.index') }}" 
                       class="lux-btn-pill w-full border border-white/30 text-white hover:bg-white/10 py-3 text-xs uppercase tracking-wider font-semibold transition text-center block">
                        Isi Formulir Penawaran
                    </a>

                    <div class="mt-8 pt-6 border-t border-white/10 space-y-3 text-xs text-[#F6EFE0]/70">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-[#C9A24B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Survei lokasi Jabodetabek gratis</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-[#C9A24B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Visualisasi 3D rendering photorealistic</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-[#C9A24B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Garansi struktur resmi hingga 3 tahun</span>
                        </div>
                    </div>
                </div>

                <!-- Related Services -->
                @if ($relatedServices->isNotEmpty())
                <div class="bg-white p-6 sm:p-7 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h4 class="font-heading text-lg font-normal text-[#1A1308] mb-4">
                        Layanan Terkait Lainnya
                    </h4>
                    <ul class="space-y-4">
                        @foreach ($relatedServices as $rel)
                        <li>
                            <a href="{{ route('services.show', $rel->slug) }}" class="group flex items-center space-x-3 text-xs text-[#1A1308]/80 hover:text-[#B58A12] transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B58A12]"></span>
                                <span class="group-hover:translate-x-1 transition-transform font-medium">{{ $rel->title }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>

        </div>
    </div>
</section>

@endsection
