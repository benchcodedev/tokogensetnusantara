<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::orderBy('urutan', 'asc')->paginate(20);
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.form', [
            'item' => new GalleryItem(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:gudang,sold,forklift',
            'urutan' => 'nullable|integer|min:0',
            'foto_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'foto_path' => 'nullable|string|max:255',
        ]);

        $item = new GalleryItem();
        $item->judul = $validated['judul'];
        $item->kategori = $validated['kategori'];
        $item->urutan = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto_file')) {
            $path = $request->file('foto_file')->store('gallery', 'public');
            $item->foto = 'storage/' . $path;
        } elseif (!empty($validated['foto_path'])) {
            $item->foto = $validated['foto_path'];
        } else {
            return back()->withErrors(['foto_file' => 'Foto wajib diunggah atau isi path foto.'])->withInput();
        }

        $item->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = GalleryItem::findOrFail($id);
        return view('admin.gallery.form', [
            'item' => $item,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = GalleryItem::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:gudang,sold,forklift',
            'urutan' => 'nullable|integer|min:0',
            'foto_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'foto_path' => 'nullable|string|max:255',
        ]);

        $item->judul = $validated['judul'];
        $item->kategori = $validated['kategori'];
        $item->urutan = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto_file')) {
            $path = $request->file('foto_file')->store('gallery', 'public');
            $item->foto = 'storage/' . $path;
        } elseif (!empty($validated['foto_path'])) {
            $item->foto = $validated['foto_path'];
        }

        $item->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Item galeri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = GalleryItem::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Item galeri berhasil dihapus.');
    }
}
