<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Conversation\ConversationResource;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function showMessageForm()
    {
        $conversations = Conversation::with(['farmer', 'messages', 'product', 'product.productImages'])->where('buyer_id', Auth::user()->id)->latest()->get();
        return Inertia::render('Messages/Index', [
            'conversations' => ConversationResource::collection($conversations)
        ]);
    }
}
