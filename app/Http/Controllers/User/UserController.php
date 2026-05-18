<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function showMessageForm()
    {
        $conversations = Conversation::with('farmer')->where('buyer_id', Auth::user()->id)->get();
        return Inertia::render('Messages/Index', [
            'conversations' => $conversations,
        ]);
    }
}
