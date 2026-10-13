<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ServiceAreaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Toko Genset Nusantara (V-GEN Jogja)
| Multi-Page Architecture (Setiap Menu Memiliki Halaman Tersendiri)
|--------------------------------------------------------------------------
*/

// Public Frontend Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/area-layanan', [ServiceAreaController::class, 'index'])->name('service-areas.index');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');

// XML Sitemap & Robots for SEO
Route::get('/sitemap.xml', function () {
    $products = Product::where('is_active', true)->get();
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    // Core Pages
    $coreRoutes = [
        ['url' => url('/'), 'prio' => '1.0'],
        ['url' => route('products.index'), 'prio' => '0.9'],
        ['url' => route('catalog.index'), 'prio' => '0.9'],
        ['url' => route('gallery.index'), 'prio' => '0.8'],
        ['url' => route('service-areas.index'), 'prio' => '0.8'],
        ['url' => route('contact.index'), 'prio' => '0.8'],
    ];

    foreach ($coreRoutes as $r) {
        $xml .= '<url>';
        $xml .= '<loc>' . $r['url'] . '</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>' . $r['prio'] . '</priority>';
        $xml .= '</url>';
    }
    
    // Dynamic Products
    foreach ($products as $p) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('product.show', $p->slug) . '</loc>';
        $xml .= '<lastmod>' . $p->updated_at->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }
    
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    $content = "User-agent: *\nAllow: /\nDisallow: /admin/\n\nSitemap: " . url('/sitemap.xml');
    return response($content, 200)->header('Content-Type', 'text/plain');
});

// Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index']);
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products CRUD
    Route::resource('products', AdminProductController::class);

    // Gallery CRUD
    Route::resource('gallery', AdminGalleryController::class);

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});
