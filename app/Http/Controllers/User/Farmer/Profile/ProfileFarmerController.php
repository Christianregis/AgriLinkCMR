<?php

namespace App\Http\Controllers\User\Farmer\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Resources\user\FarmerResource;
use App\Models\FarmerProfile;
use App\Http\Requests\farmer\FarmerProfileRequest;
use App\Http\Resources\region\RegionResource;
use App\Models\Region;


class ProfileFarmerController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $farmer = FarmerProfile::where('user_id', $user->id)->firstOrFail();

        return Inertia::render('Farmer/Profile/FarmerProfile', [
            'user' => FarmerResource::make($farmer),
        ]);
    }

    public function edit()
    {
        $user = Auth::user();

        $farmer = FarmerProfile::with('user')->where('user_id', $user->id)->first();

        return Inertia::render('Farmer/Profile/EditProfile', [
            'user' => FarmerResource::make($farmer),
            'regions' => RegionResource::collection(Region::all())
        ]);
    }
    /**
     * Fonction pour mettre a jour le profil d'un agriculteur (Pas encore finie)
     */
    public function updateProfileFarmer(FarmerProfileRequest $request)
    {
        $data = $request->validated();

        $farmer = FarmerProfile::with('user')
            ->where('user_id', Auth::user()->id)
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
