@extends('layouts.app')

@section('title', 'Kalkulator Panduan Ukuran Sepeda Anak — MORTEIN BIKE')
@section('meta_description', 'Kalkulator ukuran sepeda anak berdasarkan tinggi badan dan usia. Temukan ukuran roda 12, 14, 16, 18, 20 inci yang paling pas dan aman.')

@section('content')
<div class="py-12 lg:py-20 bg-ink" x-data="{
    tab: 'height', // height, age
    childHeight: 110,
    childAge: 5,

    get recommendation() {
        if (this.tab === 'height') {
            let h = parseInt(this.childHeight);
            if (h < 95) return { wheel: '12"', sizeNumber: '12', age: '2 - 4 Tahun', title: 'Roda 12 Inci (Balance Bike / Mini)', models: 'Mortein Little Champ 12, Mini Dash 12' };
            if (h < 105) return { wheel: '14"', sizeNumber: '14', age: '3 - 5 Tahun', title: 'Roda 14 Inci (Transisi)', models: 'Mortein Aero Lite 14' };
            if (h < 120) return { wheel: '16"', sizeNumber: '16', age: '4 - 7 Tahun', title: 'Roda 16 Inci (Koleksi Paling Populer)', models: 'Mortein Raptor 16, Candy Pop 16, Tom & Jerry 16, Kuromi 16' };
            if (h < 135) return { wheel: '18"', sizeNumber: '18', age: '6 - 9 Tahun', title: 'Roda 18 Inci (Action & Sport)', models: 'Mortein Justice League Batman 18, Bella City 18' };
            return { wheel: '20"', sizeNumber: '20', age: '8 - 12 Tahun', title: 'Roda 20 Inci (MTB & Pro BMX)', models: 'Mortein Thunder BMX 20, Trail Hunter MTB 20, Falcon Pro 20' };
        } else {
            let a = parseInt(this.childAge);
            if (a <= 3) return { wheel: '12"', sizeNumber: '12', age: '2 - 4 Tahun', title: 'Roda 12 Inci (Balance Bike / Mini)', models: 'Mortein Little Champ 12, Mini Dash 12' };
            if (a === 4) return { wheel: '14"', sizeNumber: '14', age: '3 - 5 Tahun', title: 'Roda 14 Inci (Transisi)', models: 'Mortein Aero Lite 14' };
            if (a >= 5 && a <= 6) return { wheel: '16"', sizeNumber: '16', age: '4 - 7 Tahun', title: 'Roda 16 Inci (Koleksi Paling Populer)', models: 'Mortein Raptor 16, Candy Pop 16, Tom & Jerry 16, Kuromi 16' };
            if (a >= 7 && a <= 8) return { wheel: '18"', sizeNumber: '18', age: '6 - 9 Tahun', title: 'Roda 18 Inci (Action & Sport)', models: 'Mortein Justice League Batman 18, Bella City 18' };
            return { wheel: '20"', sizeNumber: '20', age: '8 - 12 Tahun', title: 'Roda 20 Inci (MTB & Pro BMX)', models: 'Mortein Thunder BMX 20, Trail Hunter MTB 20, Falcon Pro 20' };
        }
    }
}">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs font-headline font-black uppercase tracking-widest text-mortein-hot">ALAT BANTU ORANG TUA</span>
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl text-white uppercase tracking-tight mt-1">
                KALKULATOR <span class="text-accent-yellow">PILIH SEPEDA</span> ANAK
            </h1>
            <p class="text-white/70 text-sm sm:text-base mt-3 leading-relaxed">
                Menentukan ukuran sepeda yang tepat sangat vital agar anak tidak cepat lelah, terhindar dari cedera, dan percaya diri saat mengayuh.
            </p>
        </div>

        {{-- CALCULATOR INTERACTIVE CARD --}}
        <div class="max-w-4xl mx-auto bg-ink-pure border border-white/15 rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden mb-20">
            <x-mortein.diagonal-slash direction="right" opacity="0.15" />

            <div class="relative z-10 space-y-8">
                
                {{-- Mode Switcher (Tinggi Badan vs Usia) --}}
                <div class="flex items-center justify-center">
                    <div class="inline-flex p-1.5 rounded-2xl bg-white/10 border border-white/10">
                        <button type="button" @click="tab = 'height'" :class="tab === 'height' ? 'bg-mortein text-white shadow-mortein' : 'text-white/70 hover:text-white'" class="px-6 py-2.5 rounded-xl font-headline text-sm uppercase font-black tracking-wider transition-all">
                            Berdasarkan Tinggi Badan (cm)
                        </button>
                        <button type="button" @click="tab = 'age'" :class="tab === 'age' ? 'bg-mortein text-white shadow-mortein' : 'text-white/70 hover:text-white'" class="px-6 py-2.5 rounded-xl font-headline text-sm uppercase font-black tracking-wider transition-all">
                            Berdasarkan Usia Anak
                        </button>
                    </div>
                </div>

                {{-- Input Sliders --}}
                <div class="max-w-lg mx-auto text-center space-y-4">
                    
                    {{-- Height Input Slider --}}
                    <div x-show="tab === 'height'" class="space-y-3">
                        <label class="block text-xs uppercase tracking-wider text-white/60 font-medium">Geser untuk mengatur tinggi buah hati:</label>
                        <div class="font-headline text-5xl sm:text-6xl text-accent-yellow font-black">
                            <span x-text="childHeight"></span> <span class="text-2xl text-white/60">cm</span>
                        </div>
                        <input type="range" min="80" max="155" step="1" x-model="childHeight" class="w-full h-3 bg-white/20 rounded-lg appearance-none cursor-pointer accent-mortein">
                        <div class="flex justify-between text-[11px] text-white/40">
                            <span>80 cm</span>
                            <span>115 cm</span>
                            <span>155 cm</span>
                        </div>
                    </div>

                    {{-- Age Input Slider --}}
                    <div x-show="tab === 'age'" class="space-y-3" style="display: none;">
                        <label class="block text-xs uppercase tracking-wider text-white/60 font-medium">Geser untuk memilih usia anak:</label>
                        <div class="font-headline text-5xl sm:text-6xl text-accent-yellow font-black">
                            <span x-text="childAge"></span> <span class="text-2xl text-white/60">Tahun</span>
                        </div>
                        <input type="range" min="2" max="12" step="1" x-model="childAge" class="w-full h-3 bg-white/20 rounded-lg appearance-none cursor-pointer accent-mortein">
                        <div class="flex justify-between text-[11px] text-white/40">
                            <span>2 Thn</span>
                            <span>6 Thn</span>
                            <span>12 Thn</span>
                        </div>
                    </div>

                </div>

                {{-- INSTANT RECOMMENDATION REVEAL BOX --}}
                <div class="bg-gradient-to-r from-mortein-darker via-mortein-deep to-ink-muted border border-mortein/50 rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-mortein">
                    <div class="text-center md:text-left">
                        <span class="inline-block px-3 py-1 rounded-full bg-accent-yellow text-ink text-[11px] font-headline uppercase font-black tracking-wider mb-2">
                            REKOMENDASI UKURAN TERBAIK
                        </span>
                        <div class="flex items-center justify-center md:justify-start gap-3">
                            <span class="font-headline text-5xl sm:text-6xl text-white font-black" x-text="recommendation.wheel"></span>
                            <div>
                                <h3 class="font-headline text-2xl text-white uppercase tracking-tight" x-text="recommendation.title"></h3>
                                <span class="text-xs text-white/70 block" x-text="'Untuk usia rata-rata: ' + recommendation.age"></span>
                            </div>
                        </div>
                        <p class="text-xs text-white/80 mt-3">
                            Rekomendasi model: <strong class="text-accent-yellow" x-text="recommendation.models"></strong>
                        </p>
                    </div>

                    <div class="w-full md:w-auto flex-shrink-0">
                        <a :href="'{{ url('/produk') }}?wheel_size=' + recommendation.sizeNumber" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white hover:bg-accent-yellow text-ink font-headline text-base uppercase font-black tracking-wider rounded-xl shadow-xl transition-all transform hover:scale-105 active:scale-95">
                            <span>LIHAT KOLEKSI RODA <span x-text="recommendation.wheel"></span></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- SIZE GUIDE TABLE (FROM DATABASE) --}}
        <div class="space-y-6">
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-headline text-3xl sm:text-4xl text-white uppercase tracking-tight">
                    TABEL PANDUAN LENGKAP UKURAN SEPEDA
                </h2>
                <p class="text-white/60 text-xs sm:text-sm mt-1">
                    Dapat disesuaikan dengan tinggi inseam (panjang kaki dalam dari selangkangan ke lantai).
                </p>
            </div>

            <div class="bg-ink-pure border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-white/80">
                        <thead class="bg-white/5 border-b border-white/10 text-xs uppercase font-headline text-mortein-hot">
                            <tr>
                                <th class="p-4 sm:p-5">Ukuran Roda</th>
                                <th class="p-4 sm:p-5">Rentang Usia</th>
                                <th class="p-4 sm:p-5">Tinggi Badan</th>
                                <th class="p-4 sm:p-5">Panjang Kaki (Inseam)</th>
                                <th class="p-4 sm:p-5">Model yang Disarankan</th>
                                <th class="p-4 sm:p-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($sizeGuides as $sg)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-4 sm:p-5 font-headline text-xl text-white font-bold">
                                        {{ $sg->wheel_size }}
                                    </td>
                                    <td class="p-4 sm:p-5">{{ $sg->age_range }}</td>
                                    <td class="p-4 sm:p-5 text-accent-yellow font-semibold">{{ $sg->height_range }}</td>
                                    <td class="p-4 sm:p-5 text-white/60">{{ $sg->inseam_range ?? '-' }}</td>
                                    <td class="p-4 sm:p-5 font-medium text-white/90">{{ $sg->recommended_models }}</td>
                                    <td class="p-4 sm:p-5 text-right">
                                        <a href="{{ url('/produk?wheel_size=' . preg_replace('/[^0-9]/', '', $sg->wheel_size)) }}" class="inline-flex items-center gap-1 text-xs font-headline uppercase font-black text-mortein-hot hover:text-white">
                                            <span>Lihat</span>
                                            <span>&rarr;</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
