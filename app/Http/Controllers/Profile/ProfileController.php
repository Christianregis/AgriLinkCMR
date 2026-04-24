<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\farmer\FarmerProfileRequest;
use App\Http\Resources\user\BuyerResource;
use App\Http\Resources\user\FarmerResource;
use App\Models\BuyerProfile;
use App\Models\FarmerProfile;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Fonction pour affciher le profil selon le role (Buyer ou Farmer)
     */
    public function show()
    {
        $user = Auth::user();
        if ($user->hasRole('buyer')) {
            $buyer = BuyerProfile::where('user_id', $user->id)->first();

            return Inertia::render('Buyer/Profile/BuyerProfile', [
                'buyer' => BuyerResource::make($buyer),
            ]);
        }
        if ($user->hasRole('farmer')) {
            $farmer = FarmerProfile::where('user_id', $user->id)->first();

            return Inertia::render('Farmer/Profile/FarmerProfile', [
                'user' => FarmerResource::make($farmer),
            ]);
        }
    }

    /**
     * Fonction pour mettre a jour le profil d'un agriculteur (Pas encore finie)
     */
    public function updateProfileFarmer(FarmerProfileRequest $request)
    {
        $data = $request->validated();

        $farmer = FarmerProfile::with('user')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Mise à jour user
        $farmer->user->name = $data['name'];
        $farmer->user->region_id = $data['region_id'];
        $farmer->user->bio = $data['bio'];

        if ($request->hasFile('profile_photo')) {
            $farmer->user->profile_photo = $request->file('profile_photo')
                ->store('profile_image', 'public');
        }

        $farmer->user->save();

        // Mise à jour farmer
        $farmer->village = $data['village'];
        $farmer->cultures = implode(',', $data['cultures'] ?? []);

        $farmer->save();

        return redirect()
            ->route('farmerProfile')
            ->with('success', 'Informations mises à jour !');
    }
}
