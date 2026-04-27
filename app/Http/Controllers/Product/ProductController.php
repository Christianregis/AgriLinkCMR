<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Product\FarmerProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // slug auto si non fourni
        $data['slug'] = Str::uuid();

        $data['user_id'] = Auth::user()->id;

        $product = Product::create($data);

        // gestion images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                $product->productImages()->create([
                    'path' => $path,
                    'is_primary' => $index === 0,
                    'order' => $index
                ]);
            }
        }

        return redirect()->back()->with('success', 'Produit ajouté avec succès');
    }

    public function show()
    {
        $products = Product::with(['user', 'category', 'region'])->where('user_id', Auth::user()->id)->paginate(10);
        return Inertia::render('Farmer/Products/Index', [
            'products' => FarmerProductResource::collection($products),
        ]);
    }

    public function filterProducts()
    {

    }
}
