<?php

namespace App\Http\Controllers\User\Buyer\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\buyer\Address\AddAddressRequest;
use App\Http\Resources\Address\AddressResource;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function index()
    {
        $buyer = Auth::user();
        $addresses = Address::with('user')->where('user_id', $buyer->id)->latest()->get();

        return Inertia::render('Buyer/address/ShowAddress', [
            'addresses' => AddressResource::collection($addresses),
        ]);
    }

    public function store(AddAddressRequest $request)
    {
        $data = $request->validated();
        Address::create([
            'city' => $data['city'],
            'instructions' => $data['instructions'],
            'label' => $data['label'],
            'phone' => $data['phone'],
            'region' => $data['region'],
            'street' => $data['street'],
            'type' => $data['type'],
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Nouvelle Adresse ajoutee !');
    }

    public function update(AddAddressRequest $request, mixed $address_id)
    {
        $address = Address::where('id', $address_id)->firstOrFail();
        // Vérifie que l'adresse appartient à l'utilisateur connecté
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();

        $address->update([
            'city' => $data['city'],
            'instructions' => $data['instructions'],
            'label' => $data['label'],
            'phone' => $data['phone'],
            'region' => $data['region'],
            'street' => $data['street'],
            'type' => $data['type'],
        ]);

        return redirect()->back()
            ->with('success', 'Adresse mise à jour avec succès !');
    }
    public function destroy(mixed $address_id)
    {
        $address = Address::where('id', $address_id)->firstOrFail();

        // Vérifie que l'adresse appartient à l'utilisateur connecté
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->back()
            ->with('success', 'Adresse supprimée avec succès !');
    }
}
