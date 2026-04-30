<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductInformationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,
            'description' => $this->description,

            'quantity' => $this->quantity,
            'unit' => $this->unit,

            'price' => $this->price,

            'min_order_qty' => $this->min_order_qty,

            'price_negotiable' => $this->price_negotiable,

            'harvest_date' => $this->harvest_date,
            'expires_at' => $this->expires_at,

            'status' => $this->status,
            'category' => $this->whenLoaded('category', fn() => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ]),

            'region' => $this->whenLoaded('region', fn() => [
                'id' => $this->region->id,
                'name' => $this->region->name,
            ]),

            'farmer_profile' => $this->whenLoaded('user', fn() => [
                'id' =>$this->user->id,
                'reviews_count' => $this->views_count,
                'average_rating' => $this->user->farmerProfile->average_rating,
            ]),


            'category_id' => $this->whenLoaded(
                'category',
                fn() => $this->category->id,
            ),

            'region_id' => $this->whenLoaded(
                'region',
                fn() =>
                $this->region->id,
            ),

            'product_images' => $this->whenLoaded('productImages', function () {
                return $this->productImages->map(fn($image) => [
                    'id' => $image->id,
                    'url' => asset('storage/' . $image->path),
                ]);
            }),
        ];
    }
}
