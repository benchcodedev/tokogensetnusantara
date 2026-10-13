<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Portal') - PT Surya Karya Energi</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brown: {
                            50: '#FBF8F3',
                            100: '#F5EEE4',
                            200: '#ECD3A2',
                            300: '#DEBB7D',
                            400: '#D4A356',
                            500: '#C68E3E',
                            600: '#A9752D',
                            700: '#8A5D22',
                            800: '#644218',
                            900: '#422E17',
                            950: '#2E200F',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-stone-100 text-stone-800 font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <!-- SIDEBAR -->
    <aside class="w-full md:w-64 bg-stone-900 text-stone-300 flex flex-col shrink-0 border-r border-stone-800">
        <!-- BRAND HEADER -->
        <div class="p-5 border-b border-stone-800 flex items-center space-x-3">
            <img src="{{ asset('images/logo-emblem.png') }}" alt="Logo SKE" class="h-10 w-auto object-contain">
            <div>
                <div class="font-bold text-white tracking-tight leading-none text-base">SKE ADMIN</div>
                <div class="text-[10px] text-brown-400 font-semibold tracking-wider uppercase mt-0.5">Surya Karya Energi</div>
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="p-4 space-y-1.5 flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-brown-500 text-white font-bold shadow-md shadow-brown-500/30' : 'text-stone-300 hover:bg-stone-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.projects.*') ? 'bg-brown-500 text-white font-bold shadow-md shadow-brown-500/30' : 'text-stone-300 hover:bg-stone-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Kelola Proyek</span>
            </a>

            <a href="{{ route('admin.projects.create') }}" class="flex items-center space-x-3 px-3.5 py-2 rounded-lg text-xs font-medium ml-4 transition text-stone-400 hover:text-white hover:bg-stone-800/60">
                <svg class="w-4 h-4 text-brown-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>+ Tambah Proyek Baru</span>
            </a>

            <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.messages.*') ? 'bg-brown-500 text-white font-bold shadow-md shadow-brown-500/30' : 'text-stone-300 hover:bg-stone-800 hover:text-white' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Pesan Masuk</span>
                </div>
                @php
                    $unread = \App\Models\ContactMessage::where('is_read', false)->count();
                @endphp
                @if($unread > 0)
                    <span class="px-2 py-0.5 text-xs font-bold bg-amber-500 text-stone-900 rounded-full">{{ $unread }}</span>
                @endif
            </a>

            <div class="pt-4 border-t border-stone-800"></div>

            <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-stone-400 hover:text-brown-300 hover:bg-stone-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>Lihat Website Publik</span>
            </a>
        </nav>

        <!-- USER & LOGOUT FOOTER -->
        <div class="p-4 border-t border-stone-800 bg-stone-950 flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-9 h-9 rounded-full bg-brown-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="truncate">
                    <div class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-xs text-stone-500 truncate">{{ Auth::user()->email ?? '' }}</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" title="Keluar" class="p-2 text-stone-400 hover:text-red-400 transition rounded-lg hover:bg-stone-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- TOP NAVBAR -->
        <header class="bg-white border-b border-stone-200 py-4 px-6 sm:px-8 flex justify-between items-center shadow-sm">
            <div>
                <h1 class="text-xl font-bold text-stone-900">@yield('header_title', 'Dashboard')</h1>
                <p class="text-xs text-stone-500 mt-0.5">PT Surya Karya Energi &bull; Content Management System</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.projects.create') }}" class="hidden sm:inline-flex items-center space-x-1.5 px-3.5 py-1.5 bg-brown-500 hover:bg-brown-600 text-white text-xs font-semibold rounded-lg shadow transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Proyek</span>
                </a>
                <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-semibold border border-emerald-200">
                    Sistem Aktif
                </span>
            </div>
        </header>

        <!-- FLASH NOTIFICATION IN ADMIN -->
        @if(session('success'))
            <div class="mx-6 sm:mx-8 mt-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm flex items-start justify-between">
                <div class="flex items-center space-x-3 text-emerald-800 text-sm font-medium">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 sm:mx-8 mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm flex items-start justify-between">
                <div class="flex items-center space-x-3 text-red-800 text-sm font-medium">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- BODY -->
        <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>
