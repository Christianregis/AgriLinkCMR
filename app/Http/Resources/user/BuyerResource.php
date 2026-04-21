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
            'user_id' => $this->user_id,
            'company_name' => $this->company_name,
            'buyer_type' => $this->buyer_type,
            'total_orders' => $this->total_orders,
            'user' => UserResource::make($request->user())
        ];
    }
}
