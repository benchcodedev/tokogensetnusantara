@extends('layouts.app')

@section('title', $project->title . ' — Portofolio Abadi Jaya Furniture')
@section('meta_description', $project->summary)

@section('content')

<!-- Header Banner -->
<section class="relative h-[50vh] min-h-[400px] bg-[#14100A] text-white flex items-center justify-center overflow-hidden">
    <img 
        src="{{ \App\Services\ImageService::getUrl($project->cover_image) }}" 
        alt="{{ $project->title }}" 
        class="absolute inset-0 w-full h-full object-cover opacity-30"
        fetchpriority="high"
    />
    <div class="absolute inset-0 bg-gradient-to-t from-[#14100A] via-black/40 to-transparent"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <a href="{{ route('projects.index') }}" class="inline-flex items-center space-x-2 text-xs uppercase tracking-widest text-[#C9A24B] hover:text-white mb-4 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Portofolio</span>
        </a>
        <div class="inline-block bg-[#C9A24B]/20 text-[#C9A24B] border border-[#C9A24B]/40 text-[10px] uppercase tracking-widest font-semibold px-3.5 py-1 rounded-full mb-3">
            {{ $project->category ? $project->category->name : 'Karya Unggulan' }}
        </div>
        <h1 class="font-heading text-3xl sm:text-5xl lg:text-6xl font-light text-white tracking-tight leading-tight">
            {{ $project->title }}
        </h1>
        <div class="w-16 h-0.5 bg-[#C9A24B] mx-auto mt-4"></div>
        <p class="text-xs sm:text-sm text-[#F6EFE0]/80 font-light mt-3 tracking-wider">
            {{ $project->location }} • Tahun {{ $project->project_year }}
        </p>
    </div>
</section>

<!-- Project Metadata Strip -->
<div class="bg-[#1A1308] text-[#F6EFE0] py-6 border-b border-[#B58A12]/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-xs">
            <div>
                <span class="block text-gray-400 uppercase tracking-widest text-[10px]">Tipe Proyek</span>
                <strong class="font-medium text-white text-sm mt-0.5 block">{{ $project->type ?: 'Residensial Mewah' }}</strong>
            </div>
            <div>
                <span class="block text-gray-400 uppercase tracking-widest text-[10px]">Lokasi</span>
                <strong class="font-medium text-white text-sm mt-0.5 block">{{ $project->location }}</strong>
            </div>
            <div>
                <span class="block text-gray-400 uppercase tracking-widest text-[10px]">Tahun Pengerjaan</span>
                <strong class="font-medium text-white text-sm mt-0.5 block">{{ $project->project_year }}</strong>
            </div>
            <div>
                <span class="block text-gray-400 uppercase tracking-widest text-[10px]">Kategori</span>
                <strong class="font-medium text-[#C9A24B] text-sm mt-0.5 block">{{ $project->category ? $project->category->name : 'Custom' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Main Details -->
<section class="py-16 lg:py-24 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">
            
            <!-- Left 2 Cols: Content, Materials & Gallery -->
            <div class="lg:col-span-2 space-y-12">
                
                <!-- Summary & Description -->
                <div class="bg-white p-8 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-4">
                        Konsep & Narasi Arsitektural
                    </h2>
                    <div class="w-12 h-0.5 bg-[#B58A12] mb-6"></div>
                    <div class="text-sm sm:text-base text-[#1A1308]/80 leading-relaxed font-light space-y-4">
                        <p class="text-lg font-normal text-[#B58A12]">
                            {{ $project->summary }}
                        </p>
                        <p>
                            {{ $project->description }}
                        </p>
                    </div>
                </div>

                <!-- Materials Breakdown -->
                @if ($project->materials)
                <div class="bg-white p-8 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-4">
                        Material & Komponen Utama
                    </h2>
                    <div class="w-12 h-0.5 bg-[#B58A12] mb-6"></div>
                    <p class="text-sm sm:text-base text-[#1A1308]/80 leading-relaxed font-light bg-[#FAF7F2] p-6 rounded-md border-l-4 border-[#B58A12]">
                        {{ $project->materials }}
                    </p>
                </div>
                @endif

                <!-- Embedded Video Preview if available -->
                @if ($project->video_url)
                <div class="bg-white p-8 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-4">
                        Video Tur Ruangan
                    </h2>
                    <div class="w-12 h-0.5 bg-[#B58A12] mb-6"></div>
                    <div class="aspect-video w-full rounded-md overflow-hidden bg-black shadow-lg">
                        <iframe src="{{ $project->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                @endif

                <!-- Gallery Showcase (Lightbox) -->
                @if (is_array($project->gallery_images) && count($project->gallery_images) > 0)
                <div class="bg-white p-8 sm:p-10 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-6">
                        Galeri Foto Detail
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        @foreach ($project->gallery_images as $img)
                        <div class="relative aspect-[4/3] rounded-md overflow-hidden bg-black/10 group">
                            <img src="{{ \App\Services\ImageService::getUrl($img) }}" alt="{{ $project->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <a href="{{ \App\Services\ImageService::getUrl($img) }}" 
                               class="glightbox absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white"
                               data-gallery="project-gallery"
                               data-title="{{ $project->title }}">
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

            <!-- Right 1 Col: Consultation Action & Related -->
            <div class="space-y-8">
                
                <div class="sticky top-28 bg-[#14100A] text-white p-8 sm:p-9 rounded-md border border-[#B58A12]/40 shadow-xl">
                    <span class="text-xs uppercase tracking-widest text-[#C9A24B] font-semibold block mb-2">
                        Wujudkan Ide Serupa
                    </span>
                    <h3 class="font-heading text-2xl font-normal text-white mb-4">
                        Ingin Desain Seperti Proyek Ini?
                    </h3>
                    <p class="text-xs sm:text-sm text-[#F6EFE0]/80 font-light leading-relaxed mb-6">
                        Konsultasikan konsep ini untuk ruangan Anda. Tim kami dapat menyesuaikan dimensi, warna material, dan rancangan 3D sesuai selera Anda.
                    </p>

                    <a href="https://wa.me/6283872500925?text=Halo%20Abadi%20Jaya%20Furniture,%20saya%20tertarik%20dengan%20proyek%20{{ urlencode($project->title) }}%20di%20{{ urlencode($project->location) }}.%20Mohon%20info%20estimasi%20dan%20konsultasi." 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="lux-btn-pill w-full bg-[#B58A12] text-white hover:bg-[#8F6309] py-3.5 text-xs uppercase tracking-wider font-semibold transition mb-3">
                        Tanyakan Proyek Ini via WA
                    </a>

                    <a href="{{ route('contact.index') }}" 
                       class="lux-btn-pill w-full border border-white/30 text-white hover:bg-white/10 py-3 text-xs uppercase tracking-wider font-semibold transition text-center block">
                        Jadwalkan Survei & Konsultasi
                    </a>

                    <div class="mt-8 pt-6 border-t border-white/10 text-xs text-[#F6EFE0]/70 space-y-2">
                        <p>âœ“ Tim desainer berpengalaman</p>
                        <p>âœ“ Garansi pengerjaan & material grade A</p>
                        <p>âœ“ 3 Showroom resmi di PIM & PIK 2</p>
                    </div>
                </div>

                <!-- Related Projects -->
                @if ($relatedProjects->isNotEmpty())
                <div class="bg-white p-6 sm:p-7 rounded-md border border-[#B58A12]/20 shadow-sm">
                    <h4 class="font-heading text-lg font-normal text-[#1A1308] mb-4">
                        Karya Lainnya
                    </h4>
                    <div class="space-y-4">
                        @foreach ($relatedProjects as $rel)
                        <a href="{{ route('projects.show', $rel->slug) }}" class="group flex items-center space-x-3.5">
                            <div class="w-16 h-16 rounded overflow-hidden flex-shrink-0 bg-black/10">
                                <img src="{{ \App\Services\ImageService::getUrl($rel->cover_image) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                            <div class="flex-grow">
                                <h5 class="text-xs font-semibold text-[#1A1308] group-hover:text-[#B58A12] transition line-clamp-1">
                                    {{ $rel->title }}
                                </h5>
                                <span class="text-[11px] text-gray-500 font-light block">{{ $rel->location }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</section>

@endsection
