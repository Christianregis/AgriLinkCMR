<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\region\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogProductResource extends JsonResource
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
            'min_order_qte' => $this->min_order_qty,
            'price_negotiable' => $this->price_negotiable,
            'harvest_date' => $this->harvest_date ?? null,
            'expire_at' => $this->expires_at ?? null,
            'status' => $this->status,
            'primary_image_url' => $this->getFirstMediaUrl('products', 'catalog'),
            'category' => CategoryResource::make($this->category),
            'region' => RegionResource::make($this->region),
            'average_rating' => $this->user->farmerProfile->average_rating,
            'reviews_count' => $this->views_count,
        ];
    }
}
