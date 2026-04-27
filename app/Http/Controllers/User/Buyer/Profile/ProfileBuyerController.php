<?php

namespace App\Http\Controllers\User\Buyer\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BuyerProfile;
use Inertia\Inertia;
use App\Http\Resources\user\BuyerResource;
use App\Http\Requests\buyer\BuyerProfileRequest;

class ProfileBuyerController extends Controller
{
    /**
     * Fonction pour affciher le profil selon le role (Buyer ou Farmer)
     */
    public function show()
    {
        $user = Auth::user();
        $buyer = BuyerProfile::where('user_id', $user->id)->firstOrFail();

        return Inertia::render('Buyer/Profile/BuyerProfile', [
            'buyer' => BuyerResource::make($buyer),
        ]);
    }

    /**
     * Fonction pour mettre a jour les informations d'un acheteur
     */

    public function updateProfileBuyer(BuyerProfileRequest $request)
    {
        $data = $request->validated();
        $buyer = BuyerProfile::with('user')->where('user_id', Auth::user()->id)->firstOrFail();

        $buyer->user->name = $data['name'];
        if ($request->hasFile('profile_photo')) {
            $buyer->user->profile_photo = $request->file('profile_photo')
                ->store('profile_image', 'public');
        }
        $buyer->company_name = $data['company_name'];
        $buyer->buyer_type = $data['buyer_type'];


        $buyer->save();
        return redirect()->route('buyerProfile')->with('success', 'Informations mis a jour');
    }
}
