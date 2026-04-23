<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\user\BuyerResource;
use App\Http\Resources\user\FarmerResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\BuyerProfile;
use App\Models\FarmerProfile;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if ($user->hasRole('buyer')) {
            $buyer = BuyerProfile::where('user_id', $user->id)->first();

            return Inertia::render('Buyer/Profile/BuyerProfile', [
                'user' => BuyerResource::make($buyer),
            ]);
        }
        if ($user->hasRole('farmer')) {
            $farmer = FarmerProfile::with('user')->where('user_id', $user->id)->first();

            return Inertia::render('Farmer/Profile/FarmerProfile', [
                'user' => FarmerResource::make($farmer),
            ]);
        }
    }
}
