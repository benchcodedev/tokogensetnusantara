<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $services = Service::all();
        $projects = Project::all();

        $content = view('sitemap', compact('services', 'projects'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
