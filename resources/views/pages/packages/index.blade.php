@extends('layouts.app')

@section('title', 'Paket & Harga Custom Furniture — Abadi Jaya Furniture Jakarta')
@section('meta_description', 'Pilihan paket harga interior & furniture custom luxury: Wallpanel mulai Rp4 jt/mÂ², Master Bedroom mulai Rp45 jt, Apartemen Studio mulai Rp45 jt, Apartemen 2BR mulai Rp85 jt.')

@section('content')

<!-- Header Banner -->
<section class="bg-[#14100A] text-[#F6EFE0] py-20 lg:py-24 border-b border-[#B58A12]/30 text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-xs uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block mb-3">
            Transparansi & Nilai Investasi
        </span>
        <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-light tracking-tight text-white mb-6">
            Paket & Estimasi Harga
        </h1>
        <div class="w-16 h-0.5 bg-[#C9A24B] mx-auto mb-6"></div>
        <p class="text-sm sm:text-base text-[#F6EFE0]/80 font-light max-w-2xl mx-auto leading-relaxed">
            Pilihan paket interior komprehensif dengan fleksibilitas kustomisasi material dan desain 3D gratis untuk mewujudkan visi hunian Anda.
        </p>
    </div>
</section>

<!-- Package Cards Grid -->
<section class="py-20 lg:py-28 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($packages as $pkg)
            <div class="relative bg-white rounded-md p-8 sm:p-9 border {{ $pkg->is_popular ? 'border-[#B58A12] shadow-2xl' : 'border-gray-200 shadow-sm' }} flex flex-col justify-between hover:border-[#B58A12] transition duration-300">
                
                @if ($pkg->badge)
                <div class="absolute -top-3.5 right-6">
                    <span class="bg-[#B58A12] text-white text-[10px] font-semibold uppercase tracking-widest px-3.5 py-1 rounded-full shadow-sm">
                        {{ $pkg->badge }}
                    </span>
                </div>
                @endif

                <div>
                    <h2 class="font-heading text-2xl sm:text-3xl font-normal text-[#1A1308] mb-2.5">
                        {{ $pkg->name }}
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-light mb-6">
                        {{ $pkg->description }}
                    </p>

                    <!-- Price Box -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <span class="text-xs text-gray-400 block uppercase tracking-wider mb-1">Estimasi Mulai Dari</span>
                        <div class="flex items-baseline space-x-1.5">
                            <span class="font-heading text-3xl sm:text-4xl font-light text-[#B58A12]">
                                {{ $pkg->price_display }}
                            </span>
                        </div>
                        @if($pkg->unit_label)
                        <span class="text-[11px] text-gray-400 mt-1 block">/ {{ $pkg->unit_label }}</span>
                        @endif
                    </div>

                    <!-- Features Checklist -->
                    <ul class="space-y-3.5 mb-8">
                        @if (is_array($pkg->features))
                            @foreach ($pkg->features as $feat)
                            <li class="flex items-start text-xs sm:text-sm text-[#1A1308]/85 leading-relaxed">
                                <svg class="w-4 h-4 text-[#B58A12] mr-2.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ $feat }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div>
                    <p class="text-[11px] text-gray-400 italic mb-5 leading-normal">
                        {{ $pkg->notes ?: '*Harga setelah diskon promosi, dapat berubah tergantung survei lapangan dan opsi material.' }}
                    </p>
                    <a href="https://wa.me/6283872500925?text={{ urlencode($pkg->whatsapp_message ?: 'Halo Abadi Jaya Furniture, saya tertarik dengan paket ' . $pkg->name . '. Mohon informasi lebih lanjut.') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="lux-btn-pill w-full {{ $pkg->is_popular ? 'bg-[#B58A12] text-white hover:bg-[#8F6309]' : 'border border-[#B58A12] text-[#B58A12] hover:bg-[#B58A12] hover:text-white' }} py-3.5 text-xs uppercase tracking-wider font-semibold transition flex items-center justify-center space-x-2">
                        <span>Tanya Paket Ini</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- FAQ Accordion Section (Alpine.js) -->
<section class="py-20 lg:py-24 bg-white border-t border-gray-200" x-data="{ activeFaq: null }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <span class="text-xs uppercase tracking-[0.25em] text-[#B58A12] font-semibold block mb-2">
                Pertanyaan Umum
            </span>
            <h2 class="font-heading text-3xl sm:text-4xl font-light text-[#1A1308] tracking-tight">
                Frequently Asked Questions (FAQ)
            </h2>
            <div class="w-16 h-0.5 bg-[#B58A12] mx-auto mt-4 mb-4"></div>
            <p class="text-sm text-gray-500 font-light">
                Hal-hal yang sering ditanyakan mengenai pemesanan, survei lokasi, material, dan garansi kami.
            </p>
        </div>

        <div class="space-y-4">
            @foreach ($faqs as $index => $faq)
            <div class="border border-gray-200 rounded-md overflow-hidden transition duration-200">
                <button @click="activeFaq = (activeFaq === {{ $index }} ? null : {{ $index }})" 
                        type="button" 
                        class="w-full px-6 py-5 text-left bg-white hover:bg-gray-50 flex items-center justify-between transition focus:outline-none"
                        :class="{ 'bg-gray-50': activeFaq === {{ $index }} }">
                    <span class="font-heading text-lg sm:text-xl font-normal text-[#1A1308]">
                        {{ $faq->question }}
                    </span>
                    <span class="ml-4 text-[#B58A12] flex-shrink-0">
                        <svg class="w-5 h-5 transform transition-transform duration-300" :class="{ 'rotate-180': activeFaq === {{ $index }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === {{ $index }}" 
                     x-collapse 
                     class="px-6 pb-6 pt-2 text-xs sm:text-sm text-gray-600 leading-relaxed font-light border-t border-gray-100 bg-gray-50/50">
                    {{ $faq->answer }}
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
