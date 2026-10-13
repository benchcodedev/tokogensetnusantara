<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('brand', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $brands = Brand::orderBy('nama', 'asc')->get();

        return view('admin.products.index', compact('products', 'brands'));
    }

    public function create()
    {
        $brands = Brand::orderBy('nama', 'asc')->get();
        return view('admin.products.form', [
            'product' => new Product(),
            'brands' => $brands,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|in:genset,forklift,lighting tower',
            'brand' => 'nullable|string|max:100',
            'kapasitas_kva' => 'nullable|numeric|min:0',
            'kapasitas_label' => 'nullable|string|max:100',
            'tipe' => 'required|string|in:silent,open',
            'deskripsi' => 'nullable|string',
            'spesifikasi_text' => 'nullable|string',
            'foto_utama_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'foto_utama_path' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $product = new Product();
        $product->nama = $validated['nama'];
        $product->slug = Str::slug($validated['nama']) . '-' . rand(100, 999);
        $product->kategori = $validated['kategori'];
        $product->brand = $validated['brand'] ?? null;
        $product->kapasitas_kva = $validated['kapasitas_kva'] ?? null;
        $product->kapasitas_label = $validated['kapasitas_label'] ?? null;
        $product->tipe = $validated['tipe'];
        $product->deskripsi = $validated['deskripsi'] ?? null;
        $product->is_featured = $request->has('is_featured');
        $product->is_active = $request->has('is_active');

        // Parse spesifikasi dari textarea baris per baris ("Label: Nilai")
        if (!empty($validated['spesifikasi_text'])) {
            $specs = [];
            $lines = explode("\n", str_replace("\r", "", $validated['spesifikasi_text']));
            foreach ($lines as $line) {
                if (str_contains($line, ':')) {
                    [$k, $v] = explode(':', $line, 2);
                    $specs[trim($k)] = trim($v);
                } elseif (!empty(trim($line))) {
                    $specs[] = trim($line);
                }
            }
            $product->spesifikasi = $specs;
        }

        // Handle upload foto ke storage
        if ($request->hasFile('foto_utama_file')) {
            $path = $request->file('foto_utama_file')->store('products', 'public');
            $product->foto_utama = 'storage/' . $path;
        } elseif (!empty($validated['foto_utama_path'])) {
            $product->foto_utama = $validated['foto_utama_path'];
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::orderBy('nama', 'asc')->get();

        return view('admin.products.form', [
            'product' => $product,
            'brands' => $brands,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|in:genset,forklift,lighting tower',
            'brand' => 'nullable|string|max:100',
            'kapasitas_kva' => 'nullable|numeric|min:0',
            'kapasitas_label' => 'nullable|string|max:100',
            'tipe' => 'required|string|in:silent,open',
            'deskripsi' => 'nullable|string',
            'spesifikasi_text' => 'nullable|string',
            'foto_utama_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'foto_utama_path' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $product->nama = $validated['nama'];
        $product->kategori = $validated['kategori'];
        $product->brand = $validated['brand'] ?? null;
        $product->kapasitas_kva = $validated['kapasitas_kva'] ?? null;
        $product->kapasitas_label = $validated['kapasitas_label'] ?? null;
        $product->tipe = $validated['tipe'];
        $product->deskripsi = $validated['deskripsi'] ?? null;
        $product->is_featured = $request->has('is_featured');
        $product->is_active = $request->has('is_active');

        // Parse spesifikasi dari textarea
        if (!empty($validated['spesifikasi_text'])) {
            $specs = [];
            $lines = explode("\n", str_replace("\r", "", $validated['spesifikasi_text']));
            foreach ($lines as $line) {
                if (str_contains($line, ':')) {
                    [$k, $v] = explode(':', $line, 2);
                    $specs[trim($k)] = trim($v);
                } elseif (!empty(trim($line))) {
                    $specs[] = trim($line);
                }
            }
            $product->spesifikasi = $specs;
        }

        // Handle upload foto
        if ($request->hasFile('foto_utama_file')) {
            $path = $request->file('foto_utama_file')->store('products', 'public');
            $product->foto_utama = 'storage/' . $path;
        } elseif (!empty($validated['foto_utama_path'])) {
            $product->foto_utama = $validated['foto_utama_path'];
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
