@php
    $waNumber = \App\Models\Setting::get('whatsapp_number', '6282142458076');
    $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waNumber);
    $igUrl = \App\Models\Setting::get('instagram_url', 'https://instagram.com/tokogensetnusantara');
    $igHandle = \App\Models\Setting::get('instagram_handle', '@tokogensetnusantara');
    $cities = json_decode(\App\Models\Setting::get('service_cities', '[]'), true) ?: [
        'Semarang', 'Yogyakarta', 'Jakarta', 'Tangerang', 'Bandung', 'Surabaya', 'Makassar', 'Bali'
    ];
@endphp

<footer class="footer-dark" id="kontak">
    <div class="container">
        <div class="grid-12" style="row-gap: 48px;">
            <!-- Kolom 1: Brand Info (5 kolom) -->
            <div style="grid-column: span 5;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                    <div class="brand-logo-circle" style="background-color: var(--yellow); color: var(--ink);">V</div>
                    <span style="font-family: var(--font-heading); font-weight: 800; font-size: 1.3rem; color: #FFFFFF;">
                        Toko Genset Nusantara
                    </span>
                </div>
                <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.95rem; line-height: 1.6; max-width: 420px; margin-bottom: 20px;">
                    Penjual genset (1000W - 2500 KVA), forklift, dan lighting tower. Berdiri sejak tahun 2024 di Yogyakarta.
                </p>
                <p style="color: rgba(255, 255, 255, 0.5); font-size: 0.875rem;">
                    Hub Operasional: Yogyakarta, melayani pengiriman ke berbagai kota.
                </p>
            </div>

            <!-- Kolom 2: Navigasi Halaman (2 kolom) -->
            <div style="grid-column: span 2;">
                <div class="footer-heading">Halaman</div>
                <ul class="footer-list">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}">Produk</a></li>
                    <li><a href="{{ route('catalog.index') }}">Katalog Genset</a></li>
                    <li><a href="{{ route('gallery.index') }}">Galeri</a></li>
                    <li><a href="{{ route('service-areas.index') }}">Area Layanan</a></li>
                    <li><a href="{{ route('contact.index') }}">Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kota Layanan (2 kolom) -->
            <div style="grid-column: span 2;">
                <div class="footer-heading">Kota Layanan</div>
                <ul class="footer-list">
                    @foreach($cities as $city)
                        <li>
                            <a href="{{ route('service-areas.index') }}" style="color: rgba(255, 255, 255, 0.7);">
                                {{ $city }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Kolom 4: Kontak Resmi (3 kolom) -->
            <div style="grid-column: span 3;">
                <div class="footer-heading">Kontak Resmi</div>
                <ul class="footer-list">
                    <li>
                        <strong style="color: #FFFFFF; display: block; font-size: 0.875rem;">WhatsApp:</strong>
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" style="color: var(--yellow); font-weight: 700;">
                            +{{ $waNumber }}
                        </a>
                    </li>
                    <li style="margin-top: 10px;">
                        <strong style="color: #FFFFFF; display: block; font-size: 0.875rem;">Instagram:</strong>
                        <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer">
                            {{ $igHandle }}
                        </a>
                    </li>
                    <li style="margin-top: 10px;">
                        <a href="{{ route('contact.index') }}" class="btn btn-secondary btn-sm" style="color: #FFFFFF; border-color: rgba(255,255,255,0.3); background-color: rgba(255,255,255,0.06); display: inline-flex; margin-top: 6px;">
                            Lihat Info Kontak &rarr;
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom Bar -->
        <div class="footer-bottom">
            <div>
                &copy; {{ date('Y') }} Toko Genset Nusantara (V-GEN Jogja). Hak cipta dilindungi.
            </div>
            <div class="watermark">
                Developed by BENCHCODE™
            </div>
        </div>
    </div>
</footer>
