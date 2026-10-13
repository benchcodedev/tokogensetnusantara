<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $site = SiteSetting::current();
        return view('pages.about', compact('site'));
    }
}
