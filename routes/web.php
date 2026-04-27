<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\Product\CatalogProductResource;
use App\Http\Resources\region\RegionResource;
use App\Http\Resources\user\BuyerResource;
use App\Http\Resources\user\FarmerResource;
use App\Models\Product;
use App\Models\BuyerProfile;
use App\Models\Category;
use App\Models\FarmerProfile;
use App\Models\Region;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

// Route publiques
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Route non accesibles des la connexion
Route::middleware('guest')->group(function () {});

// Route pour se connecter (Affichage du formulaire)
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('connexion');

// Route pour s'incrire (Formulaire)
Route::get('/register', function () {
    return Inertia::render('Auth/Register', [
        'regions' => RegionResource::collection(Region::all()),
    ]);
})->name('inscription');

// Route pour se connecter
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route pour s'inscire
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route pour afficher le formulaire de mot de passe oublie
Route::get('/forgot-password', function () {
    return Inertia::render('Auth/ForgotPassword');
})->name('showForgotpPassword');

// Route pour visualiser le catalogue de produits
Route::get('/catalog', function () {
    $products = Product::with(['user', 'category', 'region'])->orderBy('category_id')->paginate(10);

    return Inertia::render('Products/Index', [
        'products' => CatalogProductResource::collection($products),
        'categories' => CategoryResource::collection(Category::all()),
        'regions' => RegionResource::collection(Region::all())
    ]);
})->name('catalog');

// Route disponible des authentifications
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashbaord', function () {
        return Inertia::render('Dashboard/Index', []);
    })->name('dashboard');
});

// Routes pour l'administrateur
Route::middleware(['role:admin', 'auth'])->group(function () {
    // Routes pour l'adminstrateur ici
});

// Routes pour l'agriculteur
Route::prefix('profile')->middleware(['role:farmer', 'auth'])->group(function () {
    // Routes ici
    Route::get('/farmer', [ProfileController::class, 'show'])->name('farmerProfile');

    Route::get('/farmer/edit', function () {
        $user = Auth::user();

        $farmer = FarmerProfile::with('user')->where('user_id', $user->id)->first();

        return Inertia::render('Farmer/Profile/EditProfile', [
            'user' => FarmerResource::make($farmer),
            'regions' => RegionResource::collection(Region::all())
        ]);
    })->name('farmerProfileEdit');

    Route::put('/farmer/edit', [ProfileController::class, 'updateProfileFarmer'])->name('farmerProfileUpdate');

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
    Route::get('/buyer', [ProfileController::class, 'show'])->name('buyerProfile');

    Route::get('/buyer/edit', function () {
        $user = Auth::user();

        $buyer = BuyerProfile::with('user')->where('user_id', $user->id)->first();
        return Inertia::render('Buyer/Profile/EditProfile', [
            'user' => BuyerResource::make($buyer),
        ]);
    })->name('buyerProfileEdit');


    Route::put('/buyer/edit', [ProfileController::class, 'updateProfileBuyer'])->name('buyerProfileUpdate');
});
