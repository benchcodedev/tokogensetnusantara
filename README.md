# Toko Genset Nusantara (V-GEN Jogja)

Website Company Profile & Katalog Produk untuk **Toko Genset Nusantara (V-GEN Jogja)**. Dibangun menggunakan **Laravel 11 (Blade, Eloquent, SQLite/MySQL)** dengan perenderan server-side murni, sistem desain showroom alat berat modern tema terang, **tanpa framework JavaScript**, dan satu stylesheet CSS murni tanpa build step rumit.

---

## 🏗️ Spesifikasi Teknis & Kepatuhan Aturan

- **Framework**: Laravel 11 (PHP 8.2+)
- **Templating**: Laravel Blade (Server-Side Rendering murni)
- **Database**: SQLite (default instan dev) & MySQL (didukung via `.env`)
- **JavaScript**: **Vanilla JS total < 30 baris** (`public/js/app.js`), hanya untuk:
  1. Drawer menu navigasi mobile
  2. Lightbox galeri foto
  *(Dilarang & tanpa React, Next.js, Vue, Alpine, atau framework JS apa pun)*
- **Styling**: Single master stylesheet (`public/css/app.css` & `resources/css/app.css`) dengan CSS variables, 12-kolom grid, responsive clamp typography, tanpa Tailwind, tanpa npm/vite build dependency.
- **Tipografi Google Fonts**:
  - Heading: *Bricolage Grotesque* (700, 800)
  - Body: *Instrument Sans* (400, 500, 600)
- **Aturan Klaim Bisnis (Strict)**: Menggunakan data resmi bisnis apa adanya tanpa klaim rekaan seperti "distributor resmi", "garansi", "QC ketat", atau "load test".
- **Penanganan Foto**:
  - Jika foto belum diunggah oleh pemilik, sistem otomatis merender kotak abu bersih dengan label *"Foto belum diunggah"* tanpa mengarang visual/SVG.

---

## 🏢 Data Resmi Bisnis

- **Nama**: Toko Genset Nusantara (V-GEN Jogja)
- **Berdiri**: 2024 (Yogyakarta)
- **Produk**: Genset, Forklift, Lighting Tower
- **Rentang Kapasitas Ready Stock**: 1000W – 2500 KVA
- **Brand Mesin**: Perkins, Cummins, Yanmar, Emerald, Isuzu, Fawde, dan lainnya
- **Tipe Kanopi Unggulan**: V-GEN Ultra Silent (kanopi biru silent type) & Open Type
- **8 Kota Layanan**: Semarang, Yogyakarta, Jakarta, Tangerang, Bandung, Surabaya, Makassar, Bali
- **WhatsApp**: [https://wa.me/6282142458076](https://wa.me/6282142458076) (`+62 821-4245-8076`)
- **Instagram**: [https://instagram.com/tokogensetnusantara](https://instagram.com/tokogensetnusantara) (`@tokogensetnusantara`)
- **Watermark Pengembang**: `Developed by BENCHCODE™` (di footer)

---

## 🎨 Sistem Desain (Showroom Industrial Modern - Light Theme)

- `--bg`: `#F5F3EE` (Off-white hangat)
- `--surface`: `#FFFFFF` (Putih bersih)
- `--ink`: `#0F1B2D` (Teks utama)
- `--muted`: `#5B6676` (Teks pendukung & keterangan)
- `--line`: `#E2DED5` (Garis pembatas tipis 1px)
- `--blue`: `#0B63A8` (Biru kanopi V-GEN, link & aksen)
- `--yellow`: `#F2B705` (Tombol utama, teks warna `--ink`)
- `--dark`: `#0F1B2D` (Khusus section CTA akhir & footer)
- `--wa-green`: `#25D366` (Tombol floating WhatsApp bulat 56px)

---

## 📂 Struktur Halaman & Fitur

1. **Navbar Sticky (76px)**:
   - Logo bulat "V" + teks "Toko Genset Nusantara" satu baris
   - Menu desktop: Beranda, Produk, Katalog, Area Layanan, Kontak
   - Tombol kuning WhatsApp
   - Mobile: Tombol hamburger dengan drawer penuh (link besar + tombol WA)
2. **Hero Section (min 88vh)**:
   - Latar belakang foto genset biru di gudang full-bleed dengan dark gradient overlay di sisi kiri
   - Judul utama: `Genset ready stock. Kirim ke seluruh Indonesia.`
   - Subjudul: `Genset 1000W sampai 2500 KVA, forklift, dan lighting tower dari Yogyakarta.`
   - Tombol utama kuning "Lihat Katalog" + tombol outline putih "Tanya Harga via WhatsApp"
   - Baris angka inline di dasar hero: `1000W - 2500 KVA | 8 Kota | 6+ Brand | Sejak 2024` dengan garis pembatas putih tipis
3. **Kategori Produk (Grid Asimetris)**:
   - Blok Genset besar (7 kolom, tinggi penuh)
   - Blok susun Forklift & Lighting Tower (5 kolom)
   - Efek hover zoom halus (1.04x)
4. **Pilihan Brand Mesin**:
   - Deretan nama brand (Perkins, Cummins, Yanmar, Emerald, Isuzu, Fawde, dan lainnya)
5. **Katalog Produk (`/katalog`)**:
   - Filter bar server-side (query string, no JS): Pencarian kata kunci, Dropdown Brand, Dropdown Kapasitas (<10, 10-100, >100 KVA), Dropdown Tipe (Silent/Open)
   - Grid produk: 3 kolom desktop, 2 kolom tablet, 1 kolom mobile
   - Kartu produk: foto 4:3, nama, brand, kapasitas, tipe, tombol kuning "Tanya Harga" (membuka wa.me dengan pesan otomatis terisi nama produk)
   - Pagination bawaan Laravel yang rapi
6. **Detail Produk (`/produk/{slug}`)**:
   - Foto utama besar rasio 4:3 + deretan thumbnail
   - Badge kategori & tipe
   - Tabel spesifikasi bersih (Brand Engine, Kapasitas, Tipe Kanopi, Kategori, Parameter Teknis)
   - Tombol inquiry langsung ke WhatsApp admin
   - Grid 3 produk terkait
7. **Kenapa Memilih Kami (3 Poin Saja)**:
   - 01: Stok Ready di Gudang (foto kiri, teks kanan)
   - 02: Banyak Pilihan Brand dan Kapasitas (teks kiri, foto kanan)
   - 03: Melayani 8 Kota (foto kiri, teks kanan)
8. **Galeri Gudang & Unit Terjual**:
   - Masonry CSS columns (8-12 foto dokumentasi)
   - Klik membuka lightbox Vanilla JS responsif
   - Tombol link ke profil Instagram resmi
9. **Area Layanan**:
   - 8 kota layanan ditulis sebagai daftar tipografi besar dalam 2 kolom rapi
   - Klik nama kota membuka chat WhatsApp dengan pesan tanya pengiriman ke kota tersebut
10. **CTA Akhir & Footer**:
    - Section kontras gelap `--dark` "Butuh genset hari ini?"
    - Footer lengkap 4 kolom dengan copyright dan watermark `Developed by BENCHCODE™`
11. **Panel Admin (`/admin`)**:
    - Autentikasi session standar (Login email + password)
    - Dashboard ringkasan (metrik produk, galeri, brand)
    - CRUD Produk (upload foto ke storage, nama, kategori, brand, kapasitas, tipe, spesifikasi dinamis, status aktif/unggulan)
    - CRUD Galeri (upload foto, judul, kategori: gudang/sold/forklift, urutan)
    - Pengaturan Toko (ubah nomor WA, URL IG, headline hero)

---

## 🚀 Panduan Menjalankan Proyek

### 1. Migrasi Database & Seeding
```powershell
php artisan migrate:fresh --seed
```
*Telah otomatis terisi dengan 11 produk contoh berlabel `(contoh)`, 6 brand mesin, 9 item galeri, pengaturan bisnis resmi, dan 1 akun admin.*

### 2. Akun Login Admin
- **URL**: `http://localhost:8000/admin/login`
- **Email**: `admin@tokogenset.com`
- **Password**: `password123`

### 3. Menjalankan Server Lokal
```powershell
php artisan serve --port=8000
```
Buka browser di `http://127.0.0.1:8000`.

---

## 📁 Panduan Meletakkan Foto Asli

Untuk mengganti kotak placeholder dengan foto asli dari Instagram:
1. Letakkan file foto di folder `public/images/`:
   - `genset-biru-1.jpg` (Latar hero & kategori genset)
   - `genset-biru-2.jpg` (Kenapa kami poin 2)
   - `gudang-1.jpg` (Kenapa kami poin 1)
   - `forklift-1.jpg` (Kategori forklift)
   - `lighting-tower-1.jpg` (Kategori lighting tower)
   - `pengiriman-1.jpg` (Kenapa kami poin 3)
2. Atau unggah foto produk dan galeri baru langsung melalui Panel Admin di `/admin/products` dan `/admin/gallery` (tersimpan ke `public/storage`).
