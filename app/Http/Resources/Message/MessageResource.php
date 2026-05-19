<?php

namespace App\Http\Resources\Message;

use App\Http\Resources\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'conversation_id' => $this->conversation_id,
            'sender_id' => $this->sender_id,
            'sender' => UserResource::make($this->sender),
            'body' => $this->body,
            'attachment_path' => $this->attachment_path ? asset('/storage/' . $this->attachment_path) : null,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at
        ];
    }
}
