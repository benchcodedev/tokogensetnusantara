<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display dedicated gallery page (/galeri)
     */
    public function index(Request $request)
    {
        $query = GalleryItem::query();

        if ($request->filled('kategori') && in_array($request->kategori, ['gudang', 'sold', 'forklift'])) {
            $query->where('kategori', $request->kategori);
        }

        $items = $query->orderBy('urutan', 'asc')->paginate(12)->withQueryString();

        $counts = [
            'semua' => GalleryItem::count(),
            'gudang' => GalleryItem::where('kategori', 'gudang')->count(),
            'sold' => GalleryItem::where('kategori', 'sold')->count(),
            'forklift' => GalleryItem::where('kategori', 'forklift')->count(),
        ];

        return view('pages.gallery', compact('items', 'counts'));
    }
}
