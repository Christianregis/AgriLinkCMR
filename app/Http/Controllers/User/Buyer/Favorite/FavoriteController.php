<?php

namespace App\Http\Controllers\User\Buyer\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Resources\Favorite\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $buyer = Auth::user();
        $data = $request->validate([
            'isFavorite' => ['boolean', 'required'],
            'product_id' => ['integer', 'exists:products,id', 'required']
        ]);

        $favorite = Favorite::query()

            ->where('user_id', $buyer->id)

            ->where('product_id', $data['product_id'])

            ->first();

        if ($favorite) {

            $favorite->delete();
        } else {

            Favorite::create([

                'user_id' => $buyer->id,

                'product_id' => $data['product_id'],

            ]);
        }
        return back();
    }

    public function showFavorites()
    {

        $buyer = Auth::user();

        $favorites = $buyer
            ->favorites()
            ->with(['product', 'product.user', 'product.productImages'])
            ->latest()
            ->paginate(15);
            
        return Inertia::render('Buyer/Favorite/Index', [
            'favorites' => FavoriteResource::collection($favorites),
        ]);
    }

    public function deleteFavorite(Request $request)
    {
        $request->validate([
            'favorite_id' => ['integer', 'exists:favorites,id', 'required'],
        ]);

        $favorite = Favorite::where('id', '=', $request->input('favorite_id'))->firstOrFail();
        $favorite->delete();
        return redirect()->back()->with('success', 'Favorie enleve !');
    }
}
