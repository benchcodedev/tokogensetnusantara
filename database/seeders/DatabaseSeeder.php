<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@tokogenset.com'],
            [
                'name' => 'Admin V-GEN',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
            ]
        );

        // 2. Settings (Data Bisnis Resmi Tanpa Klaim Tambahan)
        $settings = [
            'site_name' => 'Toko Genset Nusantara (V-GEN Jogja)',
            'brand_name' => 'V-GEN Jogja',
            'established_year' => '2024',
            'capacity_range' => '1000W - 2500 KVA',
            'whatsapp_number' => '6282142458076',
            'whatsapp_url' => 'https://wa.me/6282142458076',
            'instagram_url' => 'https://instagram.com/tokogensetnusantara',
            'instagram_handle' => '@tokogensetnusantara',
            'hub_city' => 'Yogyakarta',
            'service_cities' => json_encode([
                'Semarang',
                'Yogyakarta',
                'Jakarta',
                'Tangerang',
                'Bandung',
                'Surabaya',
                'Makassar',
                'Bali',
            ]),
            'hero_headline' => 'Genset ready stock. Kirim ke seluruh Indonesia.',
            'hero_subheadline' => 'Genset 1000W sampai 2500 KVA, forklift, dan lighting tower dari Yogyakarta.',
            'hero_image' => 'images/genset-biru-1.jpg',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 3. Brands
        $brands = [
            ['nama' => 'Perkins', 'deskripsi' => 'Pabrikan mesin industri berat asal United Kingdom.'],
            ['nama' => 'Cummins', 'deskripsi' => 'Mesin diesel berdaya tahan tinggi asal Amerika Serikat.'],
            ['nama' => 'Yanmar', 'deskripsi' => 'Mesin diesel presisi dan senyap asal Jepang.'],
            ['nama' => 'Emerald', 'deskripsi' => 'Pilihan efisien untuk kebutuhan operasional komersial.'],
            ['nama' => 'Isuzu', 'deskripsi' => 'Mesin diesel andal dan teruji di iklim tropis.'],
            ['nama' => 'Fawde', 'deskripsi' => 'Mesin bertenaga dengan efisiensi bahan bakar optimal.'],
        ];

        foreach ($brands as $b) {
            Brand::updateOrCreate(
                ['slug' => Str::slug($b['nama'])],
                ['nama' => $b['nama'], 'deskripsi' => $b['deskripsi']]
            );
        }

        // 4. Products (9 Produk Contoh yang Jelas Diberi Label "(contoh)")
        $products = [
            [
                'nama' => 'Genset Emerald 5 KVA Silent (contoh)',
                'kategori' => 'genset',
                'brand' => 'Emerald',
                'kapasitas_kva' => 5,
                'kapasitas_label' => '5 KVA (4000W - 5000W)',
                'tipe' => 'silent',
                'deskripsi' => 'Genset diesel portable tipe silent dengan kanopi peredam suara. Sangat sesuai untuk ruko, klinik, kafe, dan operasional komersial kecil.',
                'spesifikasi' => [
                    'Kapasitas' => '5 KVA',
                    'Daya Watt' => '4.000W – 5.000W',
                    'Fasa' => '1 Fasa (220V)',
                    'Tipe Kanopi' => 'Silent Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                    'Sistem Starter' => 'Electric Starter',
                ],
                'foto_utama' => 'images/genset-emerald-5kva.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Genset Yanmar 10 KVA Silent (contoh)',
                'kategori' => 'genset',
                'brand' => 'Yanmar',
                'kapasitas_kva' => 10,
                'kapasitas_label' => '10 KVA (8000W)',
                'tipe' => 'silent',
                'deskripsi' => 'Genset silent dengan mesin Yanmar Jepang. Karakter mesin senyap dengan konsumsi bahan bakar yang sangat hemat.',
                'spesifikasi' => [
                    'Kapasitas' => '10 KVA',
                    'Daya Watt' => '8.000W',
                    'Fasa' => '1 Fasa / 3 Fasa',
                    'Tipe Kanopi' => 'Silent Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                    'Sistem Pendingin' => 'Radiator Water-cooled',
                ],
                'foto_utama' => 'images/genset-yanmar-10kva.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Genset Emerald 20 KVA Silent (contoh)',
                'kategori' => 'genset',
                'brand' => 'Emerald',
                'kapasitas_kva' => 20,
                'kapasitas_label' => '20 KVA (16.000W)',
                'tipe' => 'silent',
                'deskripsi' => 'Genset tipe silent kelas 20 KVA untuk kebutuhan gedung pertemuan, restoran, workshop, dan kantor cabang.',
                'spesifikasi' => [
                    'Kapasitas' => '20 KVA',
                    'Daya Watt' => '16.000W',
                    'Fasa' => '3 Fasa (380V)',
                    'Tipe Kanopi' => 'Silent Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                    'Alternator' => 'Brushless 100% Tembaga',
                ],
                'foto_utama' => 'images/genset-emerald-20kva.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'nama' => 'Genset Isuzu 25 KVA Silent (contoh)',
                'kategori' => 'genset',
                'brand' => 'Isuzu',
                'kapasitas_kva' => 25,
                'kapasitas_label' => '25 KVA (20.000W)',
                'tipe' => 'silent',
                'deskripsi' => 'Ditenagai engine Isuzu 4 silinder yang bandel. Tipe silent dengan kanopi tebal peredam suara.',
                'spesifikasi' => [
                    'Kapasitas' => '25 KVA',
                    'Daya Watt' => '20.000W',
                    'Fasa' => '3 Fasa (380V)',
                    'Tipe Kanopi' => 'Silent Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                    'Engine Model' => 'Isuzu 4JB1',
                ],
                'foto_utama' => 'images/genset-isuzu-25kva.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Genset Fawde 40 KVA Silent (contoh)',
                'kategori' => 'genset',
                'brand' => 'Fawde',
                'kapasitas_kva' => 40,
                'kapasitas_label' => '40 KVA (32.000W)',
                'tipe' => 'silent',
                'deskripsi' => 'Genset kelas menengah 40 KVA dengan efisiensi operasional tinggi untuk fasilitas perkantoran dan gudang.',
                'spesifikasi' => [
                    'Kapasitas' => '40 KVA',
                    'Daya Watt' => '32.000W',
                    'Fasa' => '3 Fasa (380V)',
                    'Tipe Kanopi' => 'Silent Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                ],
                'foto_utama' => 'images/genset-fawde-40kva.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'nama' => 'Genset Cummins 60 KVA Silent (contoh)',
                'kategori' => 'genset',
                'brand' => 'Cummins',
                'kapasitas_kva' => 60,
                'kapasitas_label' => '60 KVA (48.000W)',
                'tipe' => 'silent',
                'deskripsi' => 'Engine Cummins 4BTA3.9 Turbocharged tangguh dengan respons beban cepat untuk gedung perkantoran dan hotel.',
                'spesifikasi' => [
                    'Kapasitas' => '60 KVA',
                    'Daya Watt' => '48.000W',
                    'Fasa' => '3 Fasa (380V)',
                    'Tipe Kanopi' => 'Silent Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                ],
                'foto_utama' => 'images/genset-cummins-60kva.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Genset Perkins 100 KVA Silent (contoh)',
                'kategori' => 'genset',
                'brand' => 'Perkins',
                'kapasitas_kva' => 100,
                'kapasitas_label' => '100 KVA (80.000W)',
                'tipe' => 'silent',
                'deskripsi' => 'Mesin Perkins 1104C original standar industri manufaktur, rumah sakit, dan pusat data.',
                'spesifikasi' => [
                    'Kapasitas' => '100 KVA',
                    'Daya Watt' => '80.000W',
                    'Fasa' => '3 Fasa (380V)',
                    'Tipe Kanopi' => 'Silent Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                ],
                'foto_utama' => 'images/genset-perkins-100kva.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Genset Cummins 250 KVA Silent (contoh)',
                'kategori' => 'genset',
                'brand' => 'Cummins',
                'kapasitas_kva' => 250,
                'kapasitas_label' => '250 KVA (200.000W)',
                'tipe' => 'silent',
                'deskripsi' => 'Genset kapasitas besar untuk kawasan pabrik, industri pertambangan, dan proyek infrastruktur.',
                'spesifikasi' => [
                    'Kapasitas' => '250 KVA',
                    'Daya Watt' => '200.000W',
                    'Fasa' => '3 Fasa (380V)',
                    'Tipe Kanopi' => 'Silent Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                ],
                'foto_utama' => 'images/genset-cummins-250kva.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'nama' => 'Genset Perkins 500 KVA Open (contoh)',
                'kategori' => 'genset',
                'brand' => 'Perkins',
                'kapasitas_kva' => 500,
                'kapasitas_label' => '500 KVA (400.000W)',
                'tipe' => 'open',
                'deskripsi' => 'Genset open skid frame untuk instalasi khusus ruang powerhouse gedung bertingkat atau pabrik.',
                'spesifikasi' => [
                    'Kapasitas' => '500 KVA',
                    'Daya Watt' => '400.000W',
                    'Fasa' => '3 Fasa (380V)',
                    'Tipe Kanopi' => 'Open Type',
                    'Bahan Bakar' => 'Solar (Diesel)',
                ],
                'foto_utama' => 'images/genset-perkins-500kva.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
            // Forklift & Lighting Tower tambahan sesuai kategori
            [
                'nama' => 'Forklift Diesel 3.5 Ton (contoh)',
                'kategori' => 'forklift',
                'brand' => 'Isuzu',
                'kapasitas_kva' => null,
                'kapasitas_label' => 'Kapasitas Angkat 3.5 Ton',
                'tipe' => 'standard',
                'deskripsi' => 'Unit forklift diesel untuk kebutuhan logistik, depo pergudangan, dan operasional bongkar muat pabrik.',
                'spesifikasi' => [
                    'Kapasitas Angkat' => '3.500 kg (3.5 Ton)',
                    'Tinggi Tiang Mast' => '3 Meter (Duplex)',
                    'Mesin' => 'Diesel Isuzu',
                    'Transmisi' => 'Automatic Powershift',
                ],
                'foto_utama' => 'images/forklift-1.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Mobile Lighting Tower LED 4x400W (contoh)',
                'kategori' => 'lighting_tower',
                'brand' => 'Yanmar',
                'kapasitas_kva' => null,
                'kapasitas_label' => '4x400W LED Floodlight',
                'tipe' => 'silent',
                'deskripsi' => 'Menara penerangan mobile dengan genset terintegrasi pada roda trailer untuk proyek konstruksi dan tambang.',
                'spesifikasi' => [
                    'Lampu Sorot' => '4 x 400W High Lumen LED',
                    'Tinggi Tiang' => 'Telescopic Mast hingga 9 Meter',
                    'Genset' => 'Diesel Silent Terintegrasi',
                    'Mobilitas' => 'Trailer Roda Gandeng',
                ],
                'foto_utama' => 'images/lighting-1.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['slug' => Str::slug($p['nama'])],
                $p
            );
        }

        // 5. Gallery Items (8-12 item untuk masonry)
        $gallery = [
            ['foto' => 'images/gudang-1.jpg', 'caption' => 'Stok unit genset di gudang Yogyakarta', 'tipe' => 'gudang', 'urutan' => 1],
            ['foto' => 'images/sold-1.jpg', 'caption' => 'Unit terjual pengiriman Semarang', 'tipe' => 'sold', 'urutan' => 2],
            ['foto' => 'images/forklift-1.jpg', 'caption' => 'Unit forklift di gudang', 'tipe' => 'gudang', 'urutan' => 3],
            ['foto' => 'images/genset-biru-1.jpg', 'caption' => 'Genset V-GEN kanopi biru', 'tipe' => 'gudang', 'urutan' => 4],
            ['foto' => 'images/sold-2.jpg', 'caption' => 'Unit terjual pengiriman Surabaya', 'tipe' => 'sold', 'urutan' => 5],
            ['foto' => 'images/gudang-2.jpg', 'caption' => 'Barisan genset ready stock Yogyakarta', 'tipe' => 'gudang', 'urutan' => 6],
            ['foto' => 'images/lighting-1.jpg', 'caption' => 'Mobile lighting tower siap kirim', 'tipe' => 'gudang', 'urutan' => 7],
            ['foto' => 'images/sold-3.jpg', 'caption' => 'Unit terjual pengiriman Jakarta', 'tipe' => 'sold', 'urutan' => 8],
            ['foto' => 'images/sold-4.jpg', 'caption' => 'Unit terjual pengiriman Bali', 'tipe' => 'sold', 'urutan' => 9],
        ];

        foreach ($gallery as $g) {
            GalleryItem::updateOrCreate(
                ['foto' => $g['foto']],
                $g
            );
        }
    }
}
