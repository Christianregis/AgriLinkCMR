<?php

use App\Http\Controllers\public\PublicController;
use Illuminate\Support\Facades\Route;

// Route publiques
Route::get('/',[PublicController::class, 'home'])->name('home');

// Route pour visualiser le catalogue de produits
Route::get('/catalog', [PublicController::class, 'showCatalog'])->name('catalog');
Route::get('/product/{product_id}/info', [PublicController::class, 'showProductInfo'])->name('productInfo');
Route::get('/product/{product_id}/farmer/info', [PublicController::class, 'showFarmerInfo'])->name('showFarmerInfo');
