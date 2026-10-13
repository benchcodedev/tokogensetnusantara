@extends('layouts.app')

@section('title', $product->meta_title ?? ($product->name . ' — Sepeda Anak MORTEIN BIKE Official'))
@section('meta_description', $product->meta_description ?? ($product->summary ?? 'Spesifikasi, fitur, dan info pembelian resmi ' . $product->name . ' dari Mortein Bike.'))

@section('schema_org')
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ $product->name }}",
  "image": [
    "{{ $product->primary_image ? asset('storage/' . $product->primary_image) : asset('images/bike-placeholder.png') }}"
  ],
  "description": "{{ strip_tags($product->summary ?? $product->description) }}",
  "sku": "MORTEIN-{{ $product->id }}",
  "brand": {
    "@type": "Brand",
    "name": "MORTEIN BIKE"
  },
  @if($product->price)
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "IDR",
    "price": "{{ $product->price_discount ?? $product->price }}",
    "availability": "https://schema.org/InStock",
    "itemCondition": "https://schema.org/NewCondition"
  }
  @endif
}
</script>
@endsection

@section('content')
@php
    $defaultColor = $product->colors[0]['hex'] ?? '#E11D2E';
    $defaultColorName = $product->colors[0]['name'] ?? 'Standar';
@endphp

<div class="py-10 lg:py-16 bg-ink" x-data="{
    activeColor: '{{ $defaultColor }}',
    activeColorName: '{{ $defaultColorName }}',
    stickyCtaVisible: false
}" @scroll.window="stickyCtaVisible = window.scrollY > 450">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb Navigation --}}
        <nav class="flex items-center space-x-2 text-xs text-white/50 mb-8 overflow-x-auto whitespace-nowrap">
            <a href="{{ url('/') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ url('/produk') }}" class="hover:text-white transition">Katalog Produk</a>
            <span>/</span>
            @if($product->category)
                <a href="{{ url('/produk?kategori=' . $product->category->slug) }}" class="hover:text-white transition">{{ $product->category->name }}</a>
                <span>/</span>
            @endif
            <span class="text-white font-medium truncate">{{ $product->name }}</span>
        </nav>

        {{-- Product Overview Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
            
            {{-- LEFT: Visual Gallery & Dynamic Color Display --}}
            <div class="lg:col-span-7 space-y-6">
                
                {{-- Main Product Frame Card --}}
                <div class="relative bg-gradient-to-b from-ink-muted/90 to-ink-pure rounded-3xl p-8 sm:p-12 border border-white/10 shadow-2xl flex items-center justify-center min-h-[380px] sm:min-h-[460px] overflow-hidden group">
                    
                    {{-- Radial Background Glow adapted to active color --}}
                    <div class="absolute w-4/5 h-4/5 rounded-full blur-3xl opacity-30 transition-all duration-700 pointer-events-none" :style="'background-color: ' + activeColor"></div>
                    <x-mortein.diagonal-slash direction="right" opacity="0.1" />

                    {{-- Badges on visual --}}
                    <div class="absolute top-6 left-6 flex items-center gap-2 z-10">
                        <span class="px-3 py-1 rounded-full text-xs font-headline uppercase font-black tracking-wider bg-white/10 text-white border border-white/20">
                            RODA {{ $product->wheel_size }}"
                        </span>
                        @if($product->bikeSeries)
                            <span class="px-3 py-1 rounded-full text-xs font-headline uppercase font-black tracking-wider" style="background-color: {{ $product->bikeSeries->theme_color }}; color: #FFFFFF;">
                                {{ $product->bikeSeries->name }}
                            </span>
                        @endif
                    </div>

                    {{-- Bike Visual (Interactive Vector or Image) --}}
                    <div class="w-full relative z-10 transform transition-transform duration-500 group-hover:scale-105">
                        @if($product->primary_image)
                            <img src="{{ asset('storage/' . $product->primary_image) }}" alt="{{ $product->name }}" class="w-full h-72 sm:h-96 object-contain drop-shadow-2xl">
                        @else
                            <x-mortein.bike-placeholder 
                                :type="strtolower($product->category->name ?? 'bmx')" 
                                :color="$defaultColor" 
                                :wheelSize="$product->wheel_size . '&quot;'"
                                class="w-full h-72 sm:h-96"
                            />
                        @endif
                    </div>

                    {{-- Watermark brand logo --}}
                    <div class="absolute bottom-6 right-6 opacity-30 font-headline text-xl uppercase tracking-widest text-white">
                        MORTEIN BIKE
                    </div>
                </div>

                {{-- Interactive Color Variants Switcher --}}
                @if(!empty($product->colors) && is_array($product->colors))
                    <div class="bg-ink-pure border border-white/10 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-xs text-white/50 uppercase tracking-wider block font-medium">Pilihan Varian Warna:</span>
                            <span class="font-headline text-lg text-white uppercase font-black mt-0.5 block" x-text="activeColorName"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            @foreach($product->colors as $col)
                                <button 
                                    type="button"
                                    @click="activeColor = '{{ $col['hex'] ?? '#E11D2E' }}'; activeColorName = '{{ $col['name'] ?? '' }}'"
                                    :class="activeColor === '{{ $col['hex'] ?? '#E11D2E' }}' ? 'ring-4 ring-mortein-hot scale-110' : 'opacity-70 hover:opacity-100'"
                                    class="w-10 h-10 rounded-full border-2 border-white/50 transition-all shadow-md focus:outline-none"
                                    style="background-color: {{ $col['hex'] ?? '#E11D2E' }};"
                                    title="{{ $col['name'] ?? '' }}"
                                ></button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Fitur Unggulan List --}}
                @if(!empty($product->features) && is_array($product->features))
                    <div class="bg-ink-pure border border-white/10 rounded-3xl p-6 sm:p-8 space-y-4">
                        <h3 class="font-headline text-2xl text-white uppercase tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-accent-yellow"></span>
                            <span>FITUR & KEUNGGULAN UTAMA</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                            @foreach($product->features as $feat)
                                <div class="flex items-start gap-2.5 text-xs sm:text-sm text-white/85">
                                    <svg class="w-4 h-4 text-mortein-hot flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            {{-- RIGHT: Product Info, Price, Buying Options, Specifications --}}
            <div class="lg:col-span-5 space-y-8">
                
                {{-- Header Details --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-mortein/20 text-mortein-hot border border-mortein/30 text-xs font-headline font-black uppercase tracking-wider">
                            {{ $product->category->name ?? 'Sepeda Anak' }}
                        </span>
                        <span class="text-xs text-white/50 font-medium">
                            STANDAR SNI 100%
                        </span>
                    </div>

                    <h1 class="font-headline text-4xl sm:text-5xl text-white uppercase tracking-tight">
                        {{ $product->name }}
                    </h1>

                    @if($product->summary)
                        <p class="text-white/75 text-sm sm:text-base leading-relaxed">
                            {{ $product->summary }}
                        </p>
                    @endif

                    {{-- Pricing Section --}}
                    <div class="pt-2 flex items-baseline gap-3">
                        @if($product->price)
                            @if($product->price_discount)
                                <span class="font-headline text-4xl text-accent-yellow font-black">
                                    {{ $product->formatted_discount_price }}
                                </span>
                                <span class="text-base text-white/50 line-through">
                                    {{ $product->formatted_price }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-headline font-black bg-mortein text-white uppercase">
                                    HEMAT {{ $product->discount_percent }}%
                                </span>
                            @else
                                <span class="font-headline text-4xl text-white font-black">
                                    {{ $product->formatted_price }}
                                </span>
                            @endif
                        @else
                            <span class="text-lg text-white/80 font-semibold">
                                Hubungi Dealer Resmi untuk Harga
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Age & Height Recommendation Card --}}
                <div class="bg-gradient-to-r from-ink-muted to-ink-pure border border-white/10 rounded-2xl p-5 grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[11px] uppercase tracking-wider text-white/50 font-medium">Rentang Usia Anak</span>
                        <span class="font-headline text-2xl text-white mt-0.5 block">{{ $product->age_range }}</span>
                    </div>
                    <div>
                        <span class="block text-[11px] uppercase tracking-wider text-white/50 font-medium">Tinggi Badan Rekomendasi</span>
                        <span class="font-headline text-2xl text-accent-yellow mt-0.5 block">{{ $product->height_range }}</span>
                    </div>
                </div>

                {{-- Official Marketplace & Chat Purchase Options --}}
                <div class="space-y-4 pt-2">
                    <span class="font-headline text-xs uppercase tracking-widest text-white/60 block font-bold">
                        BELI RESMI BERGARANSI:
                    </span>
                    <x-mortein.marketplace-buttons :productName="$product->name" class="flex-col sm:flex-row" />
                </div>

                {{-- Specifications Table --}}
                @if(!empty($product->specifications) && is_array($product->specifications))
                    <div class="space-y-4 pt-4 border-t border-white/10">
                        <h3 class="font-headline text-2xl text-white uppercase tracking-tight">
                            SPESIFIKASI TEKNIS
                        </h3>

                        <div class="border border-white/10 rounded-2xl overflow-hidden divide-y divide-white/5">
                            @foreach($product->specifications as $spec)
                                <div class="grid grid-cols-3 p-3.5 text-xs sm:text-sm bg-ink-pure/60 hover:bg-white/5 transition-colors">
                                    <span class="font-semibold text-white/60 col-span-1">{{ $spec['spec'] ?? '' }}</span>
                                    <span class="text-white col-span-2">{{ $spec['value'] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Full Description HTML --}}
                @if($product->description)
                    <div class="space-y-3 pt-4 border-t border-white/10 text-white/80 text-sm leading-relaxed prose prose-invert">
                        <h3 class="font-headline text-2xl text-white uppercase tracking-tight">
                            DESKRIPSI LENGKAP
                        </h3>
                        <div>
                            {!! $product->description !!}
                        </div>
                    </div>
                @endif

            </div>

        </div>

        {{-- RELATED BIKES SECTION --}}
        @if($relatedProducts->isNotEmpty())
            <div class="mt-24 pt-16 border-t border-white/10 space-y-8">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-headline font-black uppercase tracking-widest text-mortein-hot">REKOMENDASI LAINNYA</span>
                        <h2 class="font-headline text-3xl sm:text-4xl text-white uppercase tracking-tight mt-1">
                            SEPEDA TERKAIT
                        </h2>
                    </div>
                    <a href="{{ url('/produk') }}" class="font-headline text-sm uppercase font-black text-white hover:text-mortein-hot transition">
                        Semua Model &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <x-mortein.product-card :product="$rel" />
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- MOBILE STICKY BOTTOM CTA BAR --}}
    <div x-show="stickyCtaVisible"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-ink-pure/95 backdrop-blur-md border-t border-white/20 p-4 flex items-center justify-between gap-4 shadow-2xl"
         style="display: none;">
        <div>
            <span class="text-xs text-white/60 block truncate max-w-[150px] font-medium">{{ $product->name }}</span>
            <span class="font-headline text-xl text-accent-yellow font-black leading-tight">
                {{ $product->formatted_discount_price ?? $product->formatted_price ?? 'Hubungi CS' }}
            </span>
        </div>
        <div class="flex items-center gap-2">
            <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_number', '6281234567890') }}?text={{ urlencode('Halo Mortein Bike, saya ingin memesan sepeda ' . $product->name) }}" target="_blank" rel="noopener noreferrer" class="px-5 py-3 bg-mortein text-white font-headline text-sm uppercase font-black tracking-wider rounded-xl shadow-mortein whitespace-nowrap">
                BELI SEKARANG
            </a>
        </div>
    </div>

</div>
@endsection
