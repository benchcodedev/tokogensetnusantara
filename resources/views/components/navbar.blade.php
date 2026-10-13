@php
    $waNumber = \App\Models\Setting::get('whatsapp_number', '6282142458076');
    $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waNumber);
@endphp

<header class="navbar">
    <div class="container navbar-inner">
        <!-- Logo Kiri -->
        <a href="{{ route('home') }}" class="brand-link" aria-label="Toko Genset Nusantara">
            <div class="brand-logo-circle">V</div>
            <span class="brand-name">Toko Genset Nusantara</span>
        </a>

        <!-- Menu Tengah Desktop (Satu Baris, Navigasi Multi-Halaman) -->
        <nav>
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Produk</a></li>
                <li><a href="{{ route('catalog.index') }}" class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">Katalog</a></li>
                <li><a href="{{ route('gallery.index') }}" class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}">Galeri</a></li>
                <li><a href="{{ route('service-areas.index') }}" class="nav-link {{ request()->routeIs('service-areas.*') ? 'active' : '' }}">Area Layanan</a></li>
                <li><a href="{{ route('contact.index') }}" class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">Kontak</a></li>
            </ul>
        </nav>

        <!-- Kanan: Tombol Kuning WhatsApp & Hamburger Mobile -->
        <div class="navbar-right">
            <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin bertanya unit ready stock.') }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="btn btn-primary btn-nav-wa">
                WhatsApp
            </a>

            <!-- Tombol Hamburger Mobile -->
            <button type="button" id="drawer-open" class="hamburger-btn" aria-label="Buka menu navigasi">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Drawer Penuh -->
<div id="mobile-drawer" class="mobile-drawer" role="dialog" aria-modal="true" aria-label="Menu navigasi mobile">
    <div class="drawer-header">
        <div class="brand-link">
            <div class="brand-logo-circle">V</div>
            <span class="brand-name">Toko Genset Nusantara</span>
        </div>
        <button type="button" id="drawer-close" class="drawer-close" aria-label="Tutup menu">
            &times;
        </button>
    </div>

    <div class="drawer-links">
        <a href="{{ route('home') }}" class="drawer-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('products.index') }}" class="drawer-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Produk</a>
        <a href="{{ route('catalog.index') }}" class="drawer-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">Katalog</a>
        <a href="{{ route('gallery.index') }}" class="drawer-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}">Galeri</a>
        <a href="{{ route('service-areas.index') }}" class="drawer-link {{ request()->routeIs('service-areas.*') ? 'active' : '' }}">Area Layanan</a>
        <a href="{{ route('contact.index') }}" class="drawer-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">Kontak</a>
    </div>

    <div style="padding-top: 24px; border-top: 1px solid var(--line);">
        <a href="{{ $waUrl }}?text={{ rawurlencode('Halo Toko Genset Nusantara, saya ingin bertanya unit ready stock.') }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="btn btn-primary" 
           style="width: 100%; text-align: center;">
            Hubungi via WhatsApp
        </a>
    </div>
</div>
