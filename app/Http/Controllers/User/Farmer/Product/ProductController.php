<?php

namespace App\Http\Controllers\User\Farmer\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Inertia\Inertia;
use App\Http\Resources\Product\FarmerProductResource;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\region\RegionResource;
use App\Models\Region;
use App\Models\Category;

class ProductController extends Controller
{
    public function create()
    {
        return Inertia::render('Farmer/Products/Create', [
            'categories' => CategoryResource::collection(Category::all()),
            'regions' => RegionResource::collection(Region::all())
        ]);
    }

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
}
