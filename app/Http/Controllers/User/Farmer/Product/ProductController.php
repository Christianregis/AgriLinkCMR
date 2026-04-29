<?php

namespace App\Http\Controllers\User\Farmer\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Inertia\Inertia;
use App\Http\Resources\Product\FarmerProductResource;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\Product\ProductInformationsResource;
use App\Http\Resources\region\RegionResource;
use App\Models\Region;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

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


    public function edit(string $id)
    {
        $product = Product::with(['productImages','category','region'])->where('id', '=', $id)->firstOrFail();
        return Inertia::render('Farmer/Products/Update', [
            'product' => ProductInformationsResource::make($product),
            'categories' => CategoryResource::collection(Category::all()),
            'regions' => RegionResource::collection(Region::all())
        ]);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::with(['category','user','region'])->where('id','=',$id)->firstOrFail();
        // Ensure the authenticated user owns the product
        if (Auth::user()->id != $product->user->id) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();

        // Handle slug generation if not provided or if title changes
        if (isset($data['title']) && (!isset($data['slug']) || empty($data['slug']))) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Update product details
        $product->update($data);

        // 1. Handle deleted images
        if (isset($data['deleted_image_ids']) && is_array($data['deleted_image_ids'])) {
            foreach ($data['deleted_image_ids'] as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id === $product->id) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // 2. Handle new images
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $index => $image) {
                $path = $image->store('products', 'public');

                $product->productImages()->create([
                    'path' => $path,
                    'is_primary' => false, // New images are not primary by default, logic can be added to set one as primary
                    'order' => $product->productImages()->count() + $index // Simple ordering
                ]);
            }
        }

        return redirect()->back()->with('success', 'Produit mis à jour avec succès !');
    }
}
