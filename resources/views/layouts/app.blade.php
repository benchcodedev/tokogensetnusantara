<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Genset Nusantara (V-GEN Jogja) — Genset, Forklift, Lighting Tower')</title>
    <meta name="description" content="@yield('meta_description', 'Toko Genset Nusantara (brand V-GEN Jogja) menjual genset ready stock 1000W sampai 2500 KVA, forklift, dan lighting tower dari Yogyakarta. Melayani 8 kota di Indonesia.')">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Toko Genset Nusantara (V-GEN Jogja)')">
    <meta property="og:description" content="@yield('meta_description', 'Genset ready stock 1000W sampai 2500 KVA, forklift, dan lighting tower dari Yogyakarta.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Toko Genset Nusantara">

    <!-- Google Fonts: Bricolage Grotesque (Heading) & Instrument Sans (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Single Master Stylesheet (Zero Build Step) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Schema.org LocalBusiness (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Toko Genset Nusantara",
        "alternateName": "V-GEN Jogja",
        "url": "{{ url('/') }}",
        "telephone": "+6282142458076",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Yogyakarta",
            "addressCountry": "ID"
        },
        "sameAs": [
            "https://instagram.com/tokogensetnusantara"
        ]
    }
    </script>
</head>
<body>
    <!-- Navbar Sticky -->
    <x-navbar />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Gelap -->
    <x-footer />

    <!-- Lightbox Modal untuk Galeri (Vanilla JS) -->
    <div id="lightbox-modal" class="lightbox-modal" role="dialog" aria-modal="true" aria-label="Lihat Foto Lebih Besar">
        <button type="button" id="lightbox-close" class="lightbox-close" aria-label="Tutup preview">&times;</button>
        <img id="lightbox-img" class="lightbox-img" src="" alt="Preview Foto">
    </div>

    <!-- Tombol WhatsApp Bulat Mengambang (Hijau WA, 56px) -->
    @php
        $waRaw = \App\Models\Setting::get('whatsapp_number', '6282142458076');
        $waLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waRaw);
    @endphp
    <a href="{{ $waLink }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin bertanya unit ready stock.') }}" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="floating-wa" 
       aria-label="Hubungi Toko Genset Nusantara via WhatsApp">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm.01 1.67c2.2 0 4.26.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.82c0 4.54-3.7 8.24-8.24 8.24-1.42 0-2.82-.37-4.05-1.07l-.29-.17-3.01.79.8-2.93-.19-.3a8.18 8.18 0 0 1-1.25-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.52 11.64c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.07-.39-2.03-1.25-.75-.67-1.26-1.5-1.4-1.75-.15-.25-.02-.39.11-.51.11-.11.25-.29.38-.44.12-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.12.17 1.77 2.7 4.28 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.11-.23-.17-.48-.29z"/>
        </svg>
    </a>

    <!-- Minimal Vanilla JS (Drawer & Lightbox) -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
