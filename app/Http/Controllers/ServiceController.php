<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $site = SiteSetting::current();
        $services = Service::orderBy('sort_order')->get();

        return view('pages.services.index', compact('site', 'services'));
    }

    public function show(string $slug)
    {
        $site = SiteSetting::current();
        $service = Service::where('slug', $slug)->firstOrFail();
        $relatedServices = Service::where('id', '!=', $service->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('pages.services.show', compact('site', 'service', 'relatedServices'));
    }
}
