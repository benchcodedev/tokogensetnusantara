<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroImage = Setting::get('hero_image', 'images/genset-biru-1.jpg');
        $heroHeadline = Setting::get('hero_headline', 'Genset ready stock. Kirim ke seluruh Indonesia.');
        $heroSubheadline = Setting::get('hero_subheadline', 'Genset 1000W sampai 2500 KVA, forklift, dan lighting tower dari Yogyakarta.');

        // Featured products for preview
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->take(6)
            ->get();

        // Gallery items for masonry (8-12 items)
        $galleryItems = GalleryItem::orderBy('urutan', 'asc')->take(12)->get();

        // Service cities list
        $cities = json_decode(Setting::get('service_cities', '[]'), true) ?: [
            'Semarang', 'Yogyakarta', 'Jakarta', 'Tangerang', 'Bandung', 'Surabaya', 'Makassar', 'Bali'
        ];

        // Brands
        $brands = Brand::all();

        return view('pages.home', compact(
            'heroImage',
            'heroHeadline',
            'heroSubheadline',
            'featuredProducts',
            'galleryItems',
            'cities',
            'brands'
        ));
    }
}
