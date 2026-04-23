<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Resources\region\RegionResource;
use App\Http\Resources\user\BuyerResource;
use App\Http\Resources\user\FarmerResource;
use App\Models\BuyerProfile;
use App\Models\FarmerProfile;
use App\Models\Region;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route publiques
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Route non accesibles des la connexions
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

// Route disponible des authentification
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
Route::middleware(['role:farmer', 'auth'])->group(function () {
    // Routes ici
    Route::get('/profile/farmer', [ProfileController::class, 'show'])->name('farmerProfile');

    Route::get('/profile/farmer/edit', function () {
        $user = Auth::user();

        $farmer = FarmerProfile::where('user_id', $user->id)->first();

        return Inertia::render('Farmer/Profile/EditProfile');
    })->name('farmerProfileEdit');
});

// Route pour l'acheteur
Route::middleware(['role:buyer', 'auth'])->group(function () {
    // Routes ici
    Route::get('/profile/buyer', [ProfileController::class, 'show'])->name('buyerProfile');

    Route::get('/profile/buyer/edit', function () {
        $user = Auth::user();

        $buyer = BuyerProfile::where('user_id', $user->id)->first();

        return Inertia::render('Buyer/Profile/EditProfile', [
            'buyer' => BuyerResource::make($buyer),
        ]);
    })->name('buyerProfileEdit');

});
