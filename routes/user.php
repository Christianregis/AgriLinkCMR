<?php

use App\Http\Controllers\User\Buyer\Profile\ProfileBuyerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Farmer\Product\ProductController;
use App\Http\Controllers\User\Farmer\Profile\ProfileFarmerController;


// Routes pour l'agriculteur
Route::prefix('profile')->middleware(['role:farmer', 'auth'])->group(function () {
    // Routes ici
    Route::get('/farmer', [ProfileFarmerController::class, 'show'])->name('farmerProfile');

    Route::get('/farmer/edit', [ProfileFarmerController::class, 'edit'])->name('farmerProfileEdit');

    Route::put('/farmer/edit', [ProfileFarmerController::class, 'updateProfileFarmer'])->name('farmerProfileUpdate');

    Route::get('/farmer/products', [ProductController::class, 'show'])->name('farmerProductsShow');
    Route::get('/farmer/create', [ProductController::class, 'create'])->name('farmerProductsCreate');

    Route::post('/farmer/products', [ProductController::class, 'store'])->name('farmerProductsStore');

    Route::get('/farmer/products/edit/{id}', [ProductController::class, 'edit'])->name('farmerProductsEdit');
    Route::put('/farmer/products/edit/{id}', [ProductController::class, 'update'])->name('farmerProductsUpdate');

    Route::delete('/farmer/products/delete/{product_id}', [ProductController::class, 'delete'])->name('farmerProductsDelete');
});


// Route pour l'acheteur
Route::prefix('profile')->middleware(['role:buyer', 'auth'])->group(function () {
    // Routes ici
    Route::get('/buyer', [ProfileBuyerController::class, 'show'])->name('buyerProfile');

    Route::get('/buyer/edit', [ProfileBuyerController::class, 'edit'])->name('buyerProfileEdit');

    Route::put('/buyer/edit', [ProfileBuyerController::class, 'updateProfileBuyer'])->name('buyerProfileUpdate');
});


// Routes pour l'administrateur
Route::middleware(['role:admin', 'auth'])->group(function () {});
