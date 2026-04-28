<?php

use App\Http\Controllers\public\PublicController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route publiques
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Route pour visualiser le catalogue de produits
Route::get('/catalog', [PublicController::class,'showCatalog'])->name('catalog');
