<?php

use App\Http\Controllers\User\Buyer\Profile\ProfileBuyerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\Farmer\Product\ProductController;
use App\Http\Controllers\User\Farmer\Profile\ProfileFarmerController;
use App\Models\FarmerProfile;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Resources\user\FarmerResource;
use App\Http\Resources\region\RegionResource;
use App\Models\Region;
use App\Models\Category;
use App\Http\Resources\category\CategoryResource;
use App\Models\BuyerProfile;
use App\Http\Resources\user\BuyerResource;


// Routes pour l'agriculteur
Route::prefix('profile')->middleware(['role:farmer', 'auth'])->group(function () {
    // Routes ici
    Route::get('/farmer', [ProfileFarmerController::class, 'show'])->name('farmerProfile');

    Route::get('/farmer/edit', function () {
        $user = Auth::user();

        $farmer = FarmerProfile::with('user')->where('user_id', $user->id)->first();

        return Inertia::render('Farmer/Profile/EditProfile', [
            'user' => FarmerResource::make($farmer),
            'regions' => RegionResource::collection(Region::all())
        ]);
    })->name('farmerProfileEdit');

    Route::put('/farmer/edit', [ProfileFarmerController::class, 'updateProfileFarmer'])->name('farmerProfileUpdate');

    Route::get('/farmer/products', [ProductController::class, 'show'])->name('farmerProductsShow');
    Route::get('/farmer/create', function () {
        return Inertia::render('Farmer/Products/Create', [
            'categories' => CategoryResource::collection(Category::all()),
            'regions' => RegionResource::collection(Region::all())
        ]);
    })->name('farmerProductsCreate');

    Route::post('/farmer/products', [ProductController::class, 'store'])->name('farmerProductsStore');
});


// Route pour l'acheteur
Route::prefix('profile')->middleware(['role:buyer', 'auth'])->group(function () {
    // Routes ici
    Route::get('/buyer', [ProfileBuyerController::class, 'show'])->name('buyerProfile');

    Route::get('/buyer/edit', function () {
        $user = Auth::user();

        $buyer = BuyerProfile::with('user')->where('user_id', $user->id)->first();
        return Inertia::render('Buyer/Profile/EditProfile', [
            'user' => BuyerResource::make($buyer),
        ]);
    })->name('buyerProfileEdit');


    Route::put('/buyer/edit', [ProfileBuyerController::class, 'updateProfileBuyer'])->name('buyerProfileUpdate');
});
