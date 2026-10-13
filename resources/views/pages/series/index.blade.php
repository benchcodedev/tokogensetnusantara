@extends('layouts.app')

@section('title', 'Seri Spesial Karakter & Edisi Eksklusif — MORTEIN BIKE')
@section('meta_description', 'Koleksi seri spesial sepeda anak Mortein Bike: Justice League Hero Series, Tom & Jerry Fun Series, Kuromi Sweet Magic, dan Falcon Pro Speed.')

@section('content')
<div class="py-12 lg:py-20 bg-ink">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-headline font-black uppercase tracking-widest text-mortein-hot">EDISI SPESIAL LISENSI RESMI</span>
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl text-white uppercase tracking-tight mt-1">
                SERI SPESIAL <span class="text-accent-yellow">MORTEIN BIKE</span>
            </h1>
            <p class="text-white/70 text-sm sm:text-base mt-2">
                Pilih seri dengan nuansa warna dan kepribadian yang cocok untuk buah hati Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($series as $s)
                <div class="group relative rounded-3xl p-8 sm:p-12 overflow-hidden border border-white/10 hover:border-white/30 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl flex flex-col justify-between"
                     style="background: linear-gradient(135deg, {{ $s->theme_color }}33 0%, #12080A 100%);">
                    
                    <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full blur-3xl opacity-30 pointer-events-none" style="background-color: {{ $s->theme_color }};"></div>
                    <x-mortein.diagonal-slash direction="right" opacity="0.1" />

                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3.5 py-1 rounded-full text-xs font-headline uppercase font-black tracking-wider text-white" style="background-color: {{ $s->theme_color }};">
                                {{ $s->products_count }} PILIHAN MODEL
                            </span>
                            <span class="text-xs font-headline tracking-widest text-white/50 uppercase">
                                OFFICIAL EDITION
                            </span>
                        </div>

                        <h2 class="font-headline text-4xl sm:text-5xl text-white uppercase tracking-tight group-hover:text-accent-yellow transition-colors">
                            {{ $s->name }}
                        </h2>

                        <p class="text-base text-accent-yellow font-semibold italic">
                            "{{ $s->tagline }}"
                        </p>

                        <p class="text-sm text-white/75 leading-relaxed">
                            {{ $s->description }}
                        </p>
                    </div>

                    <div class="py-8 flex items-center justify-center relative z-10 group-hover:scale-105 transition-transform duration-500">
                        <x-mortein.bike-placeholder type="bmx" :color="$s->theme_color" wheelSize="16&quot;" class="w-full h-48 drop-shadow-2xl" />
                    </div>

                    <div class="relative z-10 pt-4 border-t border-white/10 flex items-center justify-between">
                        <span class="text-xs text-white/60">Tersedia di Toko & Online</span>
                        <a href="{{ url('/seri/' . $s->slug) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-ink font-headline text-sm uppercase font-black tracking-wider transition-all transform hover:scale-105 active:scale-95 shadow-lg">
                            <span>LIHAT SERI LENGKAP</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
