<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'whatsapp_number' => Setting::get('whatsapp_number', '6282142458076'),
            'instagram_url' => Setting::get('instagram_url', 'https://instagram.com/tokogensetnusantara'),
            'instagram_handle' => Setting::get('instagram_handle', '@tokogensetnusantara'),
            'hero_headline' => Setting::get('hero_headline', 'Genset ready stock. Kirim ke seluruh Indonesia.'),
            'hero_subheadline' => Setting::get('hero_subheadline', 'Genset 1000W sampai 2500 KVA, forklift, dan lighting tower dari Yogyakarta.'),
            'hero_image' => Setting::get('hero_image', 'images/genset-biru-1.jpg'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => 'required|string|max:50',
            'instagram_url' => 'required|url|max:255',
            'instagram_handle' => 'required|string|max:100',
            'hero_headline' => 'required|string|max:255',
            'hero_subheadline' => 'required|string|max:500',
            'hero_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'hero_image_path' => 'nullable|string|max:255',
        ]);

        Setting::set('whatsapp_number', $validated['whatsapp_number']);
        Setting::set('instagram_url', $validated['instagram_url']);
        Setting::set('instagram_handle', $validated['instagram_handle']);
        Setting::set('hero_headline', $validated['hero_headline']);
        Setting::set('hero_subheadline', $validated['hero_subheadline']);

        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('settings', 'public');
            Setting::set('hero_image', 'storage/' . $path);
        } elseif (!empty($validated['hero_image_path'])) {
            Setting::set('hero_image', $validated['hero_image_path']);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
