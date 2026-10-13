<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\GalleryItem;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_gallery' => GalleryItem::count(),
            'total_brands' => Brand::count(),
        ];

        $recentProducts = Product::orderBy('created_at', 'desc')->take(5)->get();
        $recentGallery = GalleryItem::orderBy('created_at', 'desc')->take(6)->get();

        return view('admin.dashboard', compact('metrics', 'recentProducts', 'recentGallery'));
    }
}
