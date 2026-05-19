<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {

    return Conversation::query()
        ->where('id', $conversationId)
        ->where(function ($query) use ($user) {

            $query
                ->where('buyer_id', $user->id)
                ->orWhere('farmer_id', $user->id);

        })
        ->exists();
});
