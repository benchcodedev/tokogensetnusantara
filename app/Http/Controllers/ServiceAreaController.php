<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class ServiceAreaController extends Controller
{
    /**
     * Display service area page (/area-layanan)
     */
    public function index()
    {
        $cities = json_decode(Setting::get('service_cities', '[]'), true) ?: [
            'Semarang', 'Yogyakarta', 'Jakarta', 'Tangerang', 'Bandung', 'Surabaya', 'Makassar', 'Bali'
        ];

        return view('pages.service-areas', compact('cities'));
    }
}
