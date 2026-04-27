<?php

use App\Http\Controllers\AuthController;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\Product\CatalogProductResource;
use App\Http\Resources\region\RegionResource;
use App\Models\Product;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route publiques
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Route pour visualiser le catalogue de produits
Route::get('/catalog', function () {
    $products = Product::with(['user', 'category', 'region'])->orderBy('category_id')->paginate(10);

    return Inertia::render('Products/Index', [
        'products' => CatalogProductResource::collection($products),
        'categories' => CategoryResource::collection(Category::all()),
        'regions' => RegionResource::collection(Region::all())
    ]);
})->name('catalog');


// Routes pour l'administrateur
Route::middleware(['role:admin', 'auth'])->group(function () {
    // Routes pour l'adminstrateur ici
});

