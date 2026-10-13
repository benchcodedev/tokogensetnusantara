<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $site = SiteSetting::current();
        $categories = Category::orderBy('sort_order')->get();

        $query = Project::with('category')->orderBy('sort_order');

        if ($request->filled('kategori')) {
            $catSlug = $request->query('kategori');
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        $projects = $query->paginate(9)->withQueryString();

        return view('pages.projects.index', compact('site', 'categories', 'projects'));
    }

    public function show(string $slug)
    {
        $site = SiteSetting::current();
        $project = Project::with('category')->where('slug', $slug)->firstOrFail();
        $relatedProjects = Project::where('id', '!=', $project->id)
            ->where('category_id', $project->category_id)
            ->take(3)
            ->get();

        if ($relatedProjects->isEmpty()) {
            $relatedProjects = Project::where('id', '!=', $project->id)->take(3)->get();
        }

        return view('pages.projects.show', compact('site', 'project', 'relatedProjects'));
    }
}
