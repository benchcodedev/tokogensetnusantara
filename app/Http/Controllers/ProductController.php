<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product categories overview page (/produk)
     */
    public function index()
    {
        $brands = Brand::all();
        $gensetProducts = Product::where('kategori', 'genset')->where('is_active', true)->take(6)->get();
        $forkliftProducts = Product::where('kategori', 'forklift')->where('is_active', true)->get();
        $towerProducts = Product::where('kategori', 'lighting tower')->where('is_active', true)->get();

        return view('pages.products', compact(
            'brands',
            'gensetProducts',
            'forkliftProducts',
            'towerProducts'
        ));
    }

    /**
     * Display product detail page (/produk/{slug})
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related products (same category or brand, excluding current)
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('brand', $product->brand)
                      ->orWhere('kategori', $product->kategori);
            })
            ->take(3)
            ->get();

        // If fewer than 3, fill with other active products
        if ($relatedProducts->count() < 3) {
            $filler = Product::where('is_active', true)
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->take(3 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($filler);
        }

        return view('pages.product-detail', compact('product', 'relatedProducts'));
    }
}
