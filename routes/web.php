<?php

use App\Http\Controllers\AuthController;
use App\Http\Resources\region\RegionResource;
use App\Models\Region;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route publiques
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware('guest')->group(function () {});

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('connexion');

Route::get('/register', function () {
    return Inertia::render('Auth/Register', [
        'regions' => RegionResource::collection(Region::all()),
    ]);
})->name('inscription');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgot-password', function () {
    return Inertia::render('Auth/ForgotPassword');
})->name('showForgotpPassword');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashbaord', function () {
        return Inertia::render('Dashboard/Index', []);
    })->name('dashboard');
});

// Routes pour l'administrateur
Route::middleware(['role:admin'])->group(function () {
    // Routes pour l'adminstrateur ici
});

// Routes pour l'agriculteur
Route::middleware(['role:farmer'])->group(function () {
    // Routes ici
});

// Route pour l'acheteur
Route::middleware(['role:buyer'])->group(function () {});
