<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Public\AuthController;
use App\Models\Region;
use App\Http\Resources\region\RegionResource;


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


// Route disponible des authentifications
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashbaord', [AuthController::class, 'dashboard'])->name('dashboard');
});
