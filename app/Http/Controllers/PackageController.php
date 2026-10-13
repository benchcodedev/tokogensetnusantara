<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Package;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $site = SiteSetting::current();
        $packages = Package::orderBy('sort_order')->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.packages.index', compact('site', 'packages', 'faqs'));
    }
}
