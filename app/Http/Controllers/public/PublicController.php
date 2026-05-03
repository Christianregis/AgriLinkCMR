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
use App\Http\Resources\Product\ProductInformationsResource;
use App\Http\Resources\user\FarmerResource;
use App\Models\FarmerProfile;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function showCatalog(Request $request)
    {

        $products = Product::query()->withRelations()
            ->filterCategories($request->selectedCategories)
            ->filterRegion($request->selectedRegion)
            ->filterMaxPrice($request->maxPrice)
            ->filterMinRating($request->minRating)
            ->sortBy($request->sortBy)
            ->paginate(12)
            ->withQueryString();

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
        ]);
    }

    public function showProductInfo(mixed $product_id)
    {
        $product = Product::with(['category', 'user', 'region', 'productImages'])->where('id', $product_id)->firstOrFail();
        return Inertia::render('Products/Show', [
            'product' => ProductInformationsResource::make($product),
        ]);
    }

    public function showFarmerInfo(mixed $product_id)
    {
        $product = Product::where('id', $product_id)->firstOrFail();

        $farmer = FarmerProfile::where('id', $product->user->farmerProfile->id)->firstOrFail();
        return Inertia::render('Products/FarmerInfo', [
            'farmer' => FarmerResource::make($farmer),
        ]);
    }
}
