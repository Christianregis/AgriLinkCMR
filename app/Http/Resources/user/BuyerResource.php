<?php

namespace App\Http\Resources\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyerResource extends JsonResource
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
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'profile_photo_url' => $this->user->profile_photo
                ? asset('storage/'.$this->user->profile_photo)
                : null,
            'company_name' => $this->company_name,
            'buyer_type' => $this->buyer_type,
        ];
    }
}
