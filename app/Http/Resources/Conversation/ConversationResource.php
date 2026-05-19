<?php

namespace App\Http\Resources\Conversation;

use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\Product\ProductInformationsResource;
use App\Http\Resources\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'farmer_id' => $this->farmer_id,
            'buyer_id' => $this->buyer_id,
            'product_id' => $this->product_id,
            'last_message_at' => $this->last_message_at,
            'is_archived' => $this->is_archived,
            'farmer' => UserResource::make($this->farmer),
            // 'farmer' => $this->whenLoaded('farmer', function () {
            //     UserResource::make($this->farmer);
            // }),
            // 'product' => $this->whenLoaded('product', function () {
            //     ProductInformationsResource::make($this->product);
            // }),
            'product' => ProductInformationsResource::make($this->product),

            // 'messages' => $this->whenLoaded('messages', function () {
            //     MessageResource::collection($this->messages);
            // }),
            'messages'=> MessageResource::collection($this->messages),
        ];
    }
}
