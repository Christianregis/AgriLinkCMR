<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\category\CategoryResource;

class FarmerProductResource extends JsonResource
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
            'price' => (float) $this->price,

            // status enum → string
            'status' => $this->status->value ?? $this->status,

            // image principale
            'primary_image_url' => optional(
                $this->productImages[0]
            )->path
                ? asset('storage/' . $this->productImages[0]->path)
                : null,

            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
