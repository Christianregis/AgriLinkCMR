<?php

namespace App\Http\Controllers\User\Farmer\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

use App\Http\Resources\Product\FarmerProductResource;
use App\Http\Resources\Product\ProductInformationsResource;

use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\region\RegionResource;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Region;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Inertia\Inertia;

class ProductController extends Controller
{
    public function create()
    {
        return Inertia::render('Farmer/Products/Create', [
            'categories' => CategoryResource::collection(Category::all()),
            'regions' => RegionResource::collection(Region::all()),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::uuid();

        $data['user_id'] = Auth::id();

        $product = Product::create($data);

        //Upload + Spatie + sauvegarde DB
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $image) {

                $media = $product
                    ->addMedia($image)
                    ->toMediaCollection('products');

                $product->productImages()->create([
                    'path' => $media->getPathRelativeToRoot(),
                    'is_primary' => $index === 0,
                    'order' => $index,
                ]);
            }
        }

        return back()->with(
            'success',
            'Produit ajouté avec succès'
        );
    }

    public function show()
    {
        $products = Product::query()
            ->with([
                'user',
                'category',
                'region',
                'productImages',
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Farmer/Products/Index', [
            'products' => FarmerProductResource::collection($products),
        ]);
    }

    public function edit(mixed $id)
    {
        $product = Product::query()
            ->with([
                'productImages',
                'category',
                'region'
            ])
            ->findOrFail($id);

        return Inertia::render('Farmer/Products/Update', [
            'product' => ProductInformationsResource::make($product),

            'categories' => CategoryResource::collection(Category::all()),

            'regions' => RegionResource::collection(Region::all()),
        ]);
    }

    public function update(UpdateProductRequest $request, mixed $id)
    {
        $product = Product::query()
            ->with([
                'category',
                'user',
                'region',
                'productImages',
                'media'
            ])
            ->findOrFail($id);

        // 🔒 sécurité
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }

        $data = $request->validated();

        // slug auto
        if (
            isset($data['title']) &&
            empty($data['slug'])
        ) {
            $data['slug'] = Str::uuid() . '' . Str::random(20);
        }

        $product->update($data);

        /**
         * 🗑 SUPPRESSION IMAGES
         */
        if (
            isset($data['deleted_image_ids']) &&
            is_array($data['deleted_image_ids'])
        ) {

            foreach ($data['deleted_image_ids'] as $imageId) {

                $image = ProductImage::find($imageId);

                if (
                    $image &&
                    $image->product_id === $product->id
                ) {

                    // supprimer fichier
                    Storage::disk('public')->delete($image->path);

                    // supprimer media spatie lié
                    $media = $product
                        ->media()
                        ->where('file_name', basename($image->path))
                        ->first();

                    if ($media) {
                        $media->delete();
                    }

                    // supprimer DB
                    $image->delete();
                }
            }
        }

        /**
         * 📸 AJOUT NOUVELLES IMAGES
         */
        if ($request->hasFile('new_images')) {

            foreach ($request->file('new_images') as $index => $image) {

                // Spatie
                $media = $product
                    ->addMedia($image)
                    ->toMediaCollection('products');

                // DB classique
                $product->productImages()->create([
                    'path' => $media->getPathRelativeToRoot(),

                    'is_primary' => false,

                    'order' => $product
                        ->productImages()
                        ->count() + $index,
                ]);
            }
        }

        return back()->with(
            'success',
            'Produit mis à jour avec succès !'
        );
    }

    public function delete(mixed $product_id)
    {
        $product = Product::query()
            ->with([
                'productImages',
                'media'
            ])
            ->findOrFail($product_id);

        // suppression fichiers Spatie
        $product->clearMediaCollection('products');

        // suppression DB images
        $product->productImages()->delete();

        // soft delete produit
        $product->deleteOrFail();

        return back()->with(
            'success',
            'Produit supprimé !'
        );
    }
}
