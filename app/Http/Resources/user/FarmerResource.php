<?php

namespace App\Http\Resources\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'region' => $this->user->region?->name,
            'village' => $this->village,

            'culture_types' => $this->cultures ?? [],

            'bio' => $this->user->bio,

            'profile_photo_url' => $this->user->profile_photo
                ? asset('storage/' . $this->user->profile_photo)
                : null,

            'average_rating' => $this->average_rating,
            'total_sales' => $this->total_sales,
        ];
    }
}
