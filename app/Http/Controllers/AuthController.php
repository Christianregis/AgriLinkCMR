<?php

namespace App\Http\Controllers;

use App\enum\UserRole;
use App\Http\Requests\form\LoginRequest;
use App\Http\Requests\form\RegisterRequest;
use App\Models\BuyerProfile;
use App\Models\FarmerProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'region_id' => $request->input('region_id'),
            'bio' => $request->input('bio'),
            'profile_photo' => $request->hasFile('profile_photo') ? $request->file('profile_photo')->store('profile_image', 'public') : null,
            'is_active' => false,
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('account_type')
        ]);

        if ($user->role === UserRole::BUYER) {
            BuyerProfile::create([
                'user_id' => $user->id,
                'company_name' => $request->input('company_name'),
                'buyer_type' => $request->input('buyer_type')
            ]);
            $user->assignRole('buyer');

            return  back()->with('success', 'Nouvel Acheteur ajoute !');
        } else if ($user->role === UserRole::FARMER) {
            FarmerProfile::create([
                'user_id' => $user->id,
                'village' => $request->input('village'),
                'cultures' => $request->input('cultures'),
                'certification' => $request->input('certifications'),
            ]);
            $user->assignRole('farmer');
            return  back()->with('success', 'Nouveau Vendeur ajoute !');
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !$user->is_active) {
            return back()->with('error', 'Compte desactive: Veuillez l\'activer en consultant vos mails');
        }
        if (!Auth::attempt($credentials)) {
            return back()->with(
                'error',
                'Identifiants incorrects'
            );
        }
        $request->session()->regenerate();
        return redirect()->route('dashboard')->with('success', "Bienvenue $user->name");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirection vers le login
        return redirect()->route('connexion')->with('success', 'Deconnection reussi !');
    }
}
