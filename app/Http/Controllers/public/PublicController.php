<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;
use App\Http\Resources\Product\CatalogProductResource;
use App\Models\Region;
use App\Http\Resources\region\RegionResource;
use App\Models\Category;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\Favorite\FavoriteResource;
use App\Http\Resources\Product\ProductInformationsResource;
use App\Http\Resources\user\FarmerResource;
use App\Models\FarmerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function home()
    {
        $products = Product::with(['productImages', 'category', 'region'])->limit(5)->latest()->get();
        $user = Auth::user();

        return Inertia::render('Home', [
            'regions' => RegionResource::collection(Region::all()),
            'products' => CatalogProductResource::collection($products),
            'favorites' => $user ? FavoriteResource::collection($user->favorites) : null,

        ]);
    }
    public function showCatalog(Request $request)
    {

        $products = Product::query()->withRelations()
            ->filterCategories($request->selectedCategories)
            ->filterRegion($request->selectedRegion)
            ->filterMaxPrice($request->maxPrice)
            ->filterMinRating($request->minRating)
            ->sortBy($request->sortBy)
            ->availableForOrder()
            ->avaliable()
            ->paginate(12)
            ->withQueryString();

        $user = Auth::user();

        return Inertia::render('Products/Index', [
            'products' => CatalogProductResource::collection($products),
            'filters' => $request->only([
                'categories',
                'region',
                'max_price',
                'min_rating',
                'sort_by'
            ]),
            'categories' => CategoryResource::collection(Category::all()),
            'regions' => RegionResource::collection(Region::all()),
            'favorites' => $user ? FavoriteResource::collection($user->favorites) : null,
        ]);
    }

    public function showProductInfo(mixed $product_id)
    {
        $product = Product::with(['category', 'user', 'region', 'productImages', 'media'])->where('id', $product_id)->firstOrFail();
        return Inertia::render('Products/Show', [
            'product' => ProductInformationsResource::make($product),
        ]);
    }

    public function showFarmerInfo(mixed $product_id)
    {
        $product = Product::where('id', '=', $product_id)->firstOrFail();

        $farmer = FarmerProfile::where('id', '=', $product->user->farmerProfile->id)->firstOrFail();
        return Inertia::render('Products/FarmerInfo', [
            'farmer' => FarmerResource::make($farmer),
        ]);
    }

    public function about()
    {
        return Inertia::render('About', []);
    }

    public function farmerImpact()
    {
        return Inertia::render('FarmerImpact', []);
    }

    public function policies()
    {
        return Inertia::render('Policies', []);
    }
}
