<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Http\Requests\public\CatalogFilterRequest;
use App\Models\Product;
use Inertia\Inertia;
use App\Http\Resources\Product\CatalogProductResource;
use App\Models\Region;
use App\Http\Resources\region\RegionResource;
use App\Models\Category;
use App\Http\Resources\category\CategoryResource;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function showCatalog(Request $request)
    {

        $query = Product::with(['user', 'category', 'region']);

        if ($request->filled('selectedCategories')) {
            $query->whereIn('category_id', $request->selectedCategories);
        }

        if ($request->filled('selectedRegion')) {
            $query->where('region_id', $request->selectedRegion);
        }

        if ($request->filled('maxPrice')) {
            $query->where('price', '<=', $request->maxPrice);
        }

        if ($request->filled('minRating')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->whereHas('farmerProfile', function ($p0) use ($request) {
                    $p0->where('average_rating', '>=', $request->minRating);
                });
            });
        }

        switch ($request->input('sortBy')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(10)->withQueryString();

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
}
