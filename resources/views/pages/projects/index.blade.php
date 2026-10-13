@extends('layouts.app')

@section('title', 'Portofolio & Galeri Karya — Abadi Jaya Furniture')
@section('meta_description', 'Jelajahi portofolio proyek interior dan furniture custom luxury kami di kawasan Pondok Indah, Senopati, SCBD, PIK 2, dan Menteng.')

@section('content')

<!-- Header Banner -->
<section class="bg-[#14100A] text-[#F6EFE0] py-20 lg:py-24 border-b border-[#B58A12]/30 text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-xs uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block mb-3">
            Karya Nyata Bernilai Tinggi
        </span>
        <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-light tracking-tight text-white mb-6">
            Portofolio Proyek Interior
        </h1>
        <div class="w-16 h-0.5 bg-[#C9A24B] mx-auto mb-6"></div>
        <p class="text-sm sm:text-base text-[#F6EFE0]/80 font-light max-w-2xl mx-auto leading-relaxed">
            Koleksi karya interior dan furniture custom yang mencerminkan dedikasi kami terhadap detail, proporsi proporsional, dan material terbaik dunia.
        </p>
    </div>
</section>

<!-- Filter Tabs & Projects Grid -->
<section class="py-16 lg:py-24 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Category Filter Pills -->
        <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 mb-16">
            <a href="{{ route('projects.index') }}" 
               class="lux-btn-pill px-6 py-2.5 text-xs uppercase tracking-wider font-semibold transition {{ !request()->filled('kategori') ? 'bg-[#14100A] text-white shadow-md' : 'bg-white text-[#1A1308] border border-gray-200 hover:border-[#B58A12]' }}">
                Semua Kategori
            </a>
            @foreach ($categories as $cat)
            <a href="{{ route('projects.index', ['kategori' => $cat->slug]) }}" 
               class="lux-btn-pill px-6 py-2.5 text-xs uppercase tracking-wider font-semibold transition {{ request()->query('kategori') === $cat->slug ? 'bg-[#B58A12] text-white shadow-md' : 'bg-white text-[#1A1308] border border-gray-200 hover:border-[#B58A12]' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($projects as $proj)
            <div class="group bg-white rounded-md overflow-hidden border border-[#B58A12]/20 hover:border-[#B58A12] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                
                <div>
                    <!-- Photo Cover with Lightbox & Hover Zoom -->
                    <div class="relative h-72 sm:h-80 overflow-hidden bg-black/10">
                        <img 
                            src="{{ \App\Services\ImageService::getUrl($proj->cover_image) }}" 
                            alt="{{ $proj->title }}" 
                            loading="lazy" 
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4 z-10">
                            <span class="bg-[#14100A]/85 backdrop-blur-sm text-[#C9A24B] text-[10px] uppercase tracking-widest font-semibold px-3 py-1 rounded-full border border-[#C9A24B]/30">
                                {{ $proj->category ? $proj->category->name : 'Luxury' }}
                            </span>
                        </div>

                        <!-- Lightbox Button Trigger -->
                        <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition duration-300">
                            <a href="{{ \App\Services\ImageService::getUrl($proj->cover_image) }}" 
                               class="glightbox w-9 h-9 rounded-full bg-white/30 backdrop-blur-md hover:bg-white text-white hover:text-black flex items-center justify-center transition"
                               data-gallery="portfolio-list"
                               data-title="{{ $proj->title }}"
                               data-description="{{ $proj->location }} ({{ $proj->project_year }})">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                            </a>
                        </div>

                        <!-- Inset Text on Photo Bottom -->
                        <div class="absolute bottom-4 left-4 right-4 z-10 text-white">
                            <span class="text-[11px] text-[#C9A24B] font-light block">
                                {{ $proj->location }} • {{ $proj->project_year }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <h3 class="font-heading text-xl sm:text-2xl font-normal text-[#1A1308] group-hover:text-[#B58A12] transition-colors mb-2.5">
                            <a href="{{ route('projects.show', $proj->slug) }}">
                                {{ $proj->title }}
                            </a>
                        </h3>
                        <p class="text-xs sm:text-sm text-[#1A1308]/75 leading-relaxed font-light line-clamp-2">
                            {{ $proj->summary }}
                        </p>
                    </div>
                </div>

                <!-- Footer Card Action -->
                <div class="p-6 pt-0 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('projects.show', $proj->slug) }}" class="text-xs font-semibold uppercase tracking-wider text-[#B58A12] hover:text-[#8F6309] flex items-center space-x-1.5 transition">
                        <span>Lihat Detail Proyek</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>

            </div>
            @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-md border border-gray-200">
                <p class="text-gray-500 text-sm">Belum ada proyek dalam kategori ini.</p>
                <a href="{{ route('projects.index') }}" class="mt-4 inline-block text-xs uppercase tracking-wider text-[#B58A12] font-semibold underline">
                    Lihat Semua Proyek
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $projects->links() }}
        </div>

    </div>
</section>

@endsection
