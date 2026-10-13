<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact page (/kontak)
     */
    public function index()
    {
        $waNumber = Setting::get('whatsapp_number', '6282142458076');
        $igUrl = Setting::get('instagram_url', 'https://instagram.com/tokogensetnusantara');
        $igHandle = Setting::get('instagram_handle', '@tokogensetnusantara');
        $cities = json_decode(Setting::get('service_cities', '[]'), true) ?: [
            'Semarang', 'Yogyakarta', 'Jakarta', 'Tangerang', 'Bandung', 'Surabaya', 'Makassar', 'Bali'
        ];

        return view('pages.contact', compact('waNumber', 'igUrl', 'igHandle', 'cities'));
    }
}
