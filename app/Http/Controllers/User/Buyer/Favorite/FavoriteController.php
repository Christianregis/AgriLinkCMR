<?php

namespace App\Http\Controllers\User\Buyer\Favorite;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    }
}
