<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getMessages()
    {
        $user = auth()->user(); // Retrieve the authenticated user

        // Retrieve the messages where the User is either the sender or recipient
        $messages = Message::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('counselor_id', $user->id);
        })->with('user', 'counselor')
            ->get();

        return response()->json($messages, 200);
    }
}
