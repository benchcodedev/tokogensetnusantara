<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filter Brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter Kapasitas
        if ($request->filled('kapasitas')) {
            switch ($request->kapasitas) {
                case 'kecil': // < 10 KVA
                    $query->where(function ($q) {
                        $q->where('kapasitas_kva', '<', 10)
                          ->orWhere('kapasitas_label', 'like', '%W%');
                    });
                    break;
                case 'menengah': // 10 - 100 KVA
                    $query->whereBetween('kapasitas_kva', [10, 100]);
                    break;
                case 'besar': // > 100 KVA
                    $query->where('kapasitas_kva', '>', 100);
                    break;
            }
        }

        // Filter Tipe (Silent / Open)
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Pencarian Teks
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('brand', 'like', "%{$keyword}%")
                  ->orWhere('kapasitas_label', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        // Pagination 9 per page
        $products = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString();

        $brands = Brand::orderBy('nama', 'asc')->get();

        return view('pages.catalog', compact('products', 'brands'));
    }
}
