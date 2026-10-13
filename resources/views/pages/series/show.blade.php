@extends('layouts.app')

@section('title', $currentSeries->name . ' — Seri Spesial MORTEIN BIKE')
@section('meta_description', $currentSeries->description ?? ($currentSeries->name . ' resmi dari Mortein Bike. ' . $currentSeries->tagline))

@section('content')
<div class="py-12 lg:py-20 bg-ink">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        {{-- Series Thematic Banner --}}
        <div class="relative rounded-3xl p-8 sm:p-14 overflow-hidden border border-white/20 shadow-2xl"
             style="background: linear-gradient(135deg, {{ $currentSeries->theme_color }}44 0%, #12080A 100%);">
            
            <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full blur-3xl opacity-40 pointer-events-none" style="background-color: {{ $currentSeries->theme_color }};"></div>
            <x-mortein.diagonal-slash direction="right" opacity="0.15" />

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ url('/seri') }}" class="text-xs uppercase font-headline tracking-widest text-white/50 hover:text-white transition">
                            &larr; KEMBALI KE SEMUA SERI
                        </a>
                    </div>
                    <h1 class="font-headline text-5xl sm:text-6xl lg:text-7xl text-white uppercase tracking-tight">
                        {{ $currentSeries->name }}
                    </h1>
                    <p class="font-headline text-xl sm:text-2xl text-accent-yellow font-black tracking-wide italic">
                        "{{ $currentSeries->tagline }}"
                    </p>
                    <p class="text-white/80 text-sm sm:text-base max-w-2xl leading-relaxed">
                        {{ $currentSeries->description }}
                    </p>
                </div>

                <div class="lg:col-span-4 flex items-center justify-center">
                    <x-mortein.bike-placeholder 
                        type="bmx" 
                        :color="$currentSeries->theme_color" 
                        wheelSize="16&quot;" 
                        class="w-full h-56 drop-shadow-2xl" 
                    />
                </div>
            </div>
        </div>

        {{-- Products in this series --}}
        <div class="space-y-8">
            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                <h2 class="font-headline text-3xl sm:text-4xl text-white uppercase tracking-tight">
                    KOLEKSI SEPEDA PADA SERI INI
                </h2>
                <span class="text-xs font-headline uppercase font-bold text-white/60">
                    {{ $products->total() }} MODEL
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <x-mortein.product-card :product="$product" />
                @empty
                    <div class="col-span-full py-16 text-center text-white/50">
                        Belum ada produk yang didaftarkan pada seri ini.
                    </div>
                @endforelse
            </div>

            <div>
                {{ $products->links() }}
            </div>
        </div>

        {{-- Other Series suggestions --}}
        @if($otherSeries->isNotEmpty())
            <div class="pt-12 border-t border-white/10 space-y-6">
                <h3 class="font-headline text-2xl text-white uppercase tracking-tight">
                    JELAJAHI SERI LAINNYA
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($otherSeries as $os)
                        <a href="{{ url('/seri/' . $os->slug) }}" class="p-5 rounded-2xl bg-ink-pure border border-white/10 hover:border-white/30 transition-all flex items-center justify-between group">
                            <div>
                                <span class="font-headline text-lg text-white uppercase group-hover:text-accent-yellow transition-colors block">
                                    {{ $os->name }}
                                </span>
                                <span class="text-xs text-white/50 block mt-0.5">{{ $os->tagline }}</span>
                            </div>
                            <span class="text-white/40 group-hover:text-white">&rarr;</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
