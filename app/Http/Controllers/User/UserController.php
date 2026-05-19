<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageRequest;
use App\Http\Resources\Conversation\ConversationResource;
use App\Models\Conversation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Inertia\Inertia;

class UserController extends Controller
{
    public function showMessageForm()
    {
        $conversations = Conversation::with(['farmer', 'messages', 'product', 'product.productImages'])->where('buyer_id', Auth::user()->id)->latest('last_message_at')->get();
        return Inertia::render('Messages/Index', [
            'conversations' => ConversationResource::collection($conversations)
        ]);
    }

    public function sendMessage(MessageRequest $request, mixed $conversation_id)
    {
        $data = $request->validated();
        $conversation = Conversation::where('id', '=', $conversation_id)->firstOrFail();

        $media = $conversation
            ->addMedia($data['attachment_path'])
            ->toMediaCollection('attachements_path');

        $message = $conversation->messages()->create([
            'sender_id' => Auth::user()->id,
            'body' => $data['body'],
            'attachment_path' => $data['attachment_path'] ? $media->getPathRelativeToRoot() : null,
            'read_at' => Carbon::now(),
        ]);

        // Declanchement de l'evenement
        broadcast(new MessageSent($message))->toOthers();
        return back();
    }
}
