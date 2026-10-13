<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Wedding of {{ $event->nama_mempelai_pria }} & {{ $event->nama_mempelai_wanita }} - Kepada Yth. {{ $guest->nama }}</title>

    {{-- Preload Cover Image jika tersedia --}}
    @if(!empty($event->foto_cover))
        <link rel="preload" as="image" href="{{ asset('storage/' . $event->foto_cover) }}">
    @endif

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Asset Kompilasi Vite & Tailwind CSS --}}
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- CSS Variables Tema Dinamis --}}
    <style>
        :root {
            --color-primary: {{ $theme['color_primary'] ?? '#8B5E3C' }};
            --color-secondary: {{ $theme['color_secondary'] ?? '#D4AF37' }};
            --color-accent: {{ $theme['color_accent'] ?? '#C5A880' }};
            --color-bg: {{ $theme['color_bg'] ?? '#FDFBF7' }};
            --color-text: {{ $theme['color_text'] ?? '#2D2D2D' }};
            --font-heading: '{{ $theme['font_heading'] ?? 'Playfair Display' }}', serif;
            --font-body: '{{ $theme['font_body'] ?? 'Plus Jakarta Sans' }}', sans-serif;
        }

        body {
            font-family: var(--font-body);
            background-color: #1a1a1a;
            color: var(--color-text);
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        .font-heading {
            font-family: var(--font-heading);
        }

        .font-script {
            font-family: 'Great Vibes', cursive;
        }

        .font-body {
            font-family: var(--font-body);
        }

        /* Animasi Lembut Scroll Reveal */
        .reveal-element {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-element.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal-element {
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* Putaran Musik Latar */
        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spinSlow 8s linear infinite;
        }

        /* Custom Scrollbar Cantik */
        ::-webkit-scrollbar {
            width: 4px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--color-primary);
            border-radius: 4px;
        }
    </style>

    {{-- Custom CSS Tambahan jika diset pada event --}}
    @if(!empty($event->custom_css))
        <style>
            {!! $event->custom_css !!}
        </style>
    @endif
</head>
<body class="bg-stone-900 min-h-screen flex justify-center selection:bg-amber-200 selection:text-stone-900">

    {{-- Canvas Efek Background Bergerak (Fixed, Fullscreen, Tidak Mengganggu Klik) --}}
    <canvas id="bg-effect-canvas" class="fixed inset-0 pointer-events-none z-10 w-full h-full"></canvas>

    {{-- Container Utama Mobile-First (Lebar 360-430px di Desktop, 100% di HP) --}}
    <main
        x-data="invitationApp()"
        x-init="init()"
        class="relative z-20 w-full max-w-[430px] min-h-screen bg-[var(--color-bg)] text-[var(--color-text)] shadow-2xl overflow-x-hidden flex flex-col border-x border-stone-200/20"
    >
        @yield('content')
    </main>

    {{-- Script Efek Background Modular --}}
    @php
        $efek = $theme['efek_background'] ?? 'petals';
    @endphp
    @if($efek !== 'none')
        <script src="{{ asset('js/effects/' . $efek . '.js') }}"></script>
    @endif

    {{-- Script IntersectionObserver untuk Scroll Reveal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                        }
                    });
                }, {
                    threshold: 0.12,
                    rootMargin: '0px 0px -40px 0px'
                });

                document.querySelectorAll('.reveal-element').forEach(el => observer.observe(el));
            } else {
                document.querySelectorAll('.reveal-element').forEach(el => el.classList.add('is-revealed'));
            }
        });
    </script>
</body>
</html>
