<?php

use App\Http\Controllers\User\Buyer\Order\BuyerOrderController;
use App\Http\Controllers\User\Buyer\Profile\ProfileBuyerController;
use App\Http\Controllers\User\Farmer\Order\FarmerOrderController;
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

    Route::get('/farmer/orders', [FarmerOrderController::class, 'showAllOrders'])->name('farmerOrdersShow');

    Route::get('/farmer/orders/{order_id}',[FarmerOrderController::class, 'showOrder'])->name('farmerOrderView');

    Route::put('/farmer/orders/updateStatus', [FarmerOrderController::class, 'changeStatus'])->name('farmerOrderChangeStatus');
});


// Route pour l'acheteur
Route::prefix('profile')->middleware(['role:buyer', 'auth'])->group(function () {
    // Routes ici
    Route::get('/buyer', [ProfileBuyerController::class, 'show'])->name('buyerProfile');

    Route::get('/buyer/edit', [ProfileBuyerController::class, 'edit'])->name('buyerProfileEdit');

    Route::put('/buyer/edit', [ProfileBuyerController::class, 'updateProfileBuyer'])->name('buyerProfileUpdate');

    Route::get('/buyer/order/validate', [BuyerOrderController::class, 'confirmOrder'])->name('buyerOrderConfirm');

    Route::post('/buyer/order/store', [BuyerOrderController::class, 'store'])->name('buyerOrderStore');

    Route::get('/buyer/order/show', [BuyerOrderController::class, 'showOrders'])->name('buyerOrderShow');

    Route::delete('/buyer/order/{order_id}/delete', [BuyerOrderController::class, 'destroy'])->name('buyerOrderDelete');
});


// Routes pour l'administrateur
Route::middleware(['role:admin', 'auth'])->group(function () {});
