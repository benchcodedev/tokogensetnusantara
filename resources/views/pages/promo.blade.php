@extends('layouts.app')

@section('title', 'Promo & Giveaway Resmi — MORTEIN BIKE Official')
@section('meta_description', 'Ikuti giveaway berhadiah sepeda anak gratis dan dapatkan promo diskon serta cashback resmi dari Mortein Bike.')

@section('content')
<div class="py-12 lg:py-20 bg-ink">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        {{-- Page Header --}}
        <div class="text-center max-w-3xl mx-auto">
            <span class="text-xs font-headline font-black uppercase tracking-widest text-mortein-hot">PROGRAM KHUSUS KONSUMEN</span>
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl text-white uppercase tracking-tight mt-1">
                PROMO & <span class="text-accent-yellow">GIVEAWAY</span> RESMI
            </h1>
            <p class="text-white/70 text-sm sm:text-base mt-2">
                Jangan lewatkan kesempatan memenangkan unit sepeda gratis setiap bulan dan penawaran diskon spesial liburan.
            </p>
        </div>

        {{-- PROMOS LIST --}}
        <div class="space-y-12">
            @forelse($activePromos as $promo)
                <div class="bg-gradient-to-r from-ink-pure via-mortein-darker/60 to-ink-pure border border-white/15 rounded-3xl p-8 sm:p-12 shadow-2xl relative overflow-hidden"
                     x-data="{
                        endDate: '{{ $promo->end_date ? $promo->end_date->format('Y-m-d H:i:s') : '' }}',
                        days: 0, hours: 0, minutes: 0, seconds: 0,
                        init() {
                            if (!this.endDate) return;
                            this.updateTimer();
                            setInterval(() => this.updateTimer(), 1000);
                        },
                        updateTimer() {
                            const diff = new Date(this.endDate).getTime() - new Date().getTime();
                            if (diff <= 0) {
                                this.days = 0; this.hours = 0; this.minutes = 0; this.seconds = 0;
                                return;
                            }
                            this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                            this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        }
                     }">

                    <x-mortein.diagonal-slash direction="right" opacity="0.1" />

                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        {{-- Left Info --}}
                        <div class="lg:col-span-8 space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="px-3.5 py-1 rounded-full text-xs font-headline uppercase font-black tracking-wider {{ $promo->isGiveaway() ? 'bg-mortein text-white shadow-mortein animate-pulse' : 'bg-accent-yellow text-ink' }}">
                                    {{ $promo->isGiveaway() ? '★ GIVEAWAY RESMI' : 'PROMO DISKON' }}
                                </span>
                                @if($promo->end_date)
                                    <span class="text-xs text-white/60">
                                        Berakhir: {{ $promo->end_date->translatedFormat('d F Y') }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl text-white uppercase tracking-tight">
                                {{ $promo->title }}
                            </h2>

                            <p class="text-white/80 text-sm sm:text-base leading-relaxed">
                                {{ $promo->summary ?? $promo->description }}
                            </p>

                            {{-- Terms & Conditions list if any --}}
                            @if(!empty($promo->terms) && is_array($promo->terms))
                                <div class="bg-black/40 border border-white/10 rounded-2xl p-5 space-y-2 mt-4">
                                    <span class="font-headline text-xs text-accent-yellow uppercase tracking-wider block font-bold">
                                        SYARAT & CARA MENGIKUTI:
                                    </span>
                                    <ul class="space-y-1.5 text-xs text-white/80 list-disc list-inside">
                                        @foreach($promo->terms as $term)
                                            <li>{{ $term }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- CTA Button --}}
                            <div class="pt-4 flex flex-wrap gap-4">
                                @if($promo->instagram_link)
                                    <a href="{{ $promo->instagram_link }}" target="_blank" rel="noopener noreferrer" class="px-8 py-3.5 bg-gradient-to-r from-mortein to-mortein-hot text-white font-headline text-base uppercase font-black tracking-wider rounded-xl shadow-mortein transition-all transform hover:scale-105 active:scale-95 flex items-center gap-2">
                                        <span>IKUTI DI INSTAGRAM</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                @endif
                                @if($promo->cta_url && $promo->cta_text)
                                    <a href="{{ $promo->cta_url }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white font-headline text-base uppercase font-black tracking-wider rounded-xl transition">
                                        {{ $promo->cta_text }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Right: Countdown Box or Giveaway Badge --}}
                        <div class="lg:col-span-4 flex flex-col items-center justify-center text-center space-y-6">
                            @if($promo->isGiveaway())
                                <x-mortein.giveaway-badge size="170" centerText="WIN" :link="$promo->instagram_link" />
                            @endif

                            @if($promo->end_date)
                                <div class="w-full bg-ink-pure/80 border border-white/15 rounded-2xl p-5 space-y-2">
                                    <span class="text-[11px] uppercase tracking-wider text-white/50 font-bold block">SISA WAKTU:</span>
                                    <div class="grid grid-cols-4 gap-2 text-center">
                                        <div class="bg-white/5 rounded-xl p-2">
                                            <span class="font-headline text-2xl sm:text-3xl text-accent-yellow font-black block" x-text="days">0</span>
                                            <span class="text-[9px] text-white/50 uppercase">Hari</span>
                                        </div>
                                        <div class="bg-white/5 rounded-xl p-2">
                                            <span class="font-headline text-2xl sm:text-3xl text-white font-black block" x-text="hours">0</span>
                                            <span class="text-[9px] text-white/50 uppercase">Jam</span>
                                        </div>
                                        <div class="bg-white/5 rounded-xl p-2">
                                            <span class="font-headline text-2xl sm:text-3xl text-white font-black block" x-text="minutes">0</span>
                                            <span class="text-[9px] text-white/50 uppercase">Menit</span>
                                        </div>
                                        <div class="bg-white/5 rounded-xl p-2">
                                            <span class="font-headline text-2xl sm:text-3xl text-mortein-hot font-black block" x-text="seconds">0</span>
                                            <span class="text-[9px] text-white/50 uppercase">Detik</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-20 text-white/50">
                    Saat ini belum ada promo aktif. Pantau Instagram kami untuk pengumuman berikutnya!
                </div>
            @endforelse
        </div>

        {{-- PAST PROMOS / ARCHIVES --}}
        @if($pastPromos->isNotEmpty())
            <div class="pt-16 border-t border-white/10 space-y-6">
                <h3 class="font-headline text-2xl text-white/60 uppercase tracking-tight">
                    ARSIP PROGRAM YANG TELAH SELESAI
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($pastPromos as $past)
                        <div class="p-5 rounded-2xl bg-ink-pure/60 border border-white/5 space-y-2 opacity-60">
                            <span class="text-[10px] text-white/40 uppercase block">Berakhir {{ $past->end_date->translatedFormat('d M Y') }}</span>
                            <h4 class="font-headline text-lg text-white uppercase">{{ $past->title }}</h4>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
