<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'buyer_id' => $this->buyer_id,
            'farmer_id' => $this->farmer_id,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'delivery_address' => $this->delivery_address,
            'total_amount' => $this->total_amount,
            'notes' => $this->notes,
            'created_at' => $this->created_at->format("Y-m-d"),
            'updated_at' => $this->updated_at->format("Y-m-d"),
            'farmer' => $this->whenLoaded('farmer', function () {
                return UserResource::make($this->farmer);
            }),
            'buyer' => $this->whenLoaded('buyer', function () {
                return UserResource::make($this->buyer);
            }),
            'order_items' => $this->whenLoaded('orderItems', function () {
                return OrderItemsResource::collection($this->orderItems);
            }),
        ];
    }
}
