<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
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
    public function sendMessages(Request $request)
    {
        $user = auth()->user(); // Assuming the user is authenticated
        $counselorId = $request->input('counselor_id');
        $content = $request->input('content');

        // Create a new message instance
        $message = new Message();
        $message->user_id = $user->id;
        $message->counselor_id = $counselorId;
        $message->content = $content;
        $message->save();

        // Broadcast the message using Pusher
        event(new MessageSent($message));

        return response()->json(['message' => 'Message sent successfully', 'data' => $message], 200);
    }

}
