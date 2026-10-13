<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — Toko Genset Nusantara</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background-color: var(--bg);">
    <div class="admin-layout">
        <!-- Sidebar Kiri -->
        <aside class="admin-sidebar">
            <div style="margin-bottom: 32px; padding-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div class="brand-logo-circle" style="background-color: var(--yellow); color: var(--ink);">V</div>
                    <div>
                        <div style="font-family: var(--font-heading); font-weight: 800; font-size: 1.05rem; color: #FFFFFF; line-height: 1.1;">
                            V-GEN Jogja
                        </div>
                        <div style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.5); text-transform: uppercase; letter-spacing: 0.05em;">
                            Admin Panel
                        </div>
                    </div>
                </div>
            </div>

            <nav style="display: flex; flex-direction: column; gap: 4px;">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    Produk &amp; Katalog
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    Galeri &amp; Dokumentasi
                </a>
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    Pengaturan Toko
                </a>
            </nav>

            <div style="margin-top: auto; padding-top: 40px;">
                <div style="padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                    <a href="{{ route('home') }}" target="_blank" style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.6); margin-bottom: 12px; display: block;">
                        &larr; Lihat Website Utama
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm" style="width: 100%; border: none; background-color: rgba(255, 255, 255, 0.1); color: #FFFFFF;">
                            Keluar (Logout)
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="admin-main">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="margin-left: 20px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
