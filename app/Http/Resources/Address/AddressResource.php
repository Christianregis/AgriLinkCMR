<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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

            'label' => $this->label,

            'type' => $this->type,

            'street' => $this->street,

            'city' => $this->city,

            'region' => $this->region,

            'phone' => $this->phone,

            'instructions' => $this->instructions,
            'recipient_name' => $this->whenLoaded('user', function () {
                return $this->user->name;
            }),
        ];
    }
}
