<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $projects = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $project = new Project([
            'year' => (int) date('Y'),
            'status' => 'Operasional',
            'is_featured' => false,
            'category' => 'PLTS / Solar',
        ]);

        return view('admin.projects.form', [
            'project' => $project,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'capacity' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:2100',
            'status' => 'required|string|max:50',
            'cover_image_url' => 'nullable|string|max:1000',
            'cover_image_file' => 'nullable|image|max:10240',
            'description' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'gallery_files.*' => 'nullable|image|max:10240',
        ]);

        // Auto generate unique slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Handle Cover Image
        $coverImage = $validated['cover_image_url'] ?? 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=1200&q=80';
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/projects');
            if (!File::exists($destPath)) {
                File::makeDirectory($destPath, 0755, true);
            }
            $file->move($destPath, $filename);
            $coverImage = '/uploads/projects/' . $filename;
        }

        $project = Project::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'location' => $validated['location'],
            'client' => $validated['client'],
            'capacity' => $validated['capacity'],
            'year' => $validated['year'],
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'cover_image' => $coverImage,
            'description' => $validated['description'],
        ]);

        // Handle Gallery Uploads
        if ($request->hasFile('gallery_files')) {
            $galleryDest = public_path('uploads/projects/gallery');
            if (!File::exists($galleryDest)) {
                File::makeDirectory($galleryDest, 0755, true);
            }
            $order = 1;
            foreach ($request->file('gallery_files') as $file) {
                if ($file && $file->isValid()) {
                    $gFilename = time() . '_' . $order . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move($galleryDest, $gFilename);
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image_url' => '/uploads/projects/gallery/' . $gFilename,
                        'caption' => $project->title,
                        'sort_order' => $order,
                    ]);
                    $order++;
                }
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek baru "' . $project->title . '" berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $project = Project::with('images')->findOrFail($id);

        return view('admin.projects.form', [
            'project' => $project,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'capacity' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:2100',
            'status' => 'required|string|max:50',
            'cover_image_url' => 'nullable|string|max:1000',
            'cover_image_file' => 'nullable|image|max:10240',
            'description' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'gallery_files.*' => 'nullable|image|max:10240',
        ]);

        if ($project->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $project->slug = $slug;
        }

        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/projects');
            if (!File::exists($destPath)) {
                File::makeDirectory($destPath, 0755, true);
            }
            $file->move($destPath, $filename);
            $project->cover_image = '/uploads/projects/' . $filename;
        } elseif ($request->filled('cover_image_url')) {
            $project->cover_image = $request->cover_image_url;
        }

        $project->title = $validated['title'];
        $project->category = $validated['category'];
        $project->location = $validated['location'];
        $project->client = $validated['client'];
        $project->capacity = $validated['capacity'];
        $project->year = $validated['year'];
        $project->status = $validated['status'];
        $project->is_featured = $request->boolean('is_featured');
        $project->description = $validated['description'];
        $project->save();

        if ($request->filled('delete_gallery_images')) {
            $toDeleteIds = $request->input('delete_gallery_images');
            ProjectImage::whereIn('id', $toDeleteIds)->where('project_id', $project->id)->delete();
        }

        if ($request->hasFile('gallery_files')) {
            $galleryDest = public_path('uploads/projects/gallery');
            if (!File::exists($galleryDest)) {
                File::makeDirectory($galleryDest, 0755, true);
            }
            $maxSort = ProjectImage::where('project_id', $project->id)->max('sort_order') ?? 0;
            $order = $maxSort + 1;
            foreach ($request->file('gallery_files') as $file) {
                if ($file && $file->isValid()) {
                    $gFilename = time() . '_' . $order . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move($galleryDest, $gFilename);
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image_url' => '/uploads/projects/gallery/' . $gFilename,
                        'caption' => $project->title,
                        'sort_order' => $order,
                    ]);
                    $order++;
                }
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek "' . $project->title . '" berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $title = $project->title;
        $project->images()->delete();
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek "' . $title . '" berhasil dihapus.');
    }
}
