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

class PublicController extends Controller
{
    public function showCatalog()
    {
        $products = Product::with(['user', 'category', 'region'])->orderBy('category_id')->paginate(10);

        return Inertia::render('Products/Index', [
            'products' => CatalogProductResource::collection($products),
            'categories' => CategoryResource::collection(Category::all()),
            'regions' => RegionResource::collection(Region::all())
        ]);
    }
}
