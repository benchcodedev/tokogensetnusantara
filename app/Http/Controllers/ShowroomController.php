<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ShowroomController extends Controller
{
    public function index()
    {
        $site = SiteSetting::current();
        $showrooms = Showroom::orderBy('sort_order')->get();

        return view('pages.showroom.index', compact('site', 'showrooms'));
    }
}
