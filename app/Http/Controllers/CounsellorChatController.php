<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class CounsellorChatController extends Controller
{
    public function getMessages()
    {
        $counselor = auth()->user(); // Retrieve the authenticated counselor

        // Retrieve the messages where the Counselor is either the sender or recipient
        $messages = Message::where(function ($query) use ($counselor) {
            $query->where('counselor_id', $counselor->id)
                ->orWhere('user_id', $counselor->id);
        })->with('user', 'counselor')
            ->get();

        return response()->json($messages, 200);
    }

    public function sendMessage(Request $request)
    {
        $counselor = auth()->user();
        $message = new Message();
        $conversation = new Conversation();
    
        // Determine the sender and receiver based on the sender_type
        if ($request->input('sender_type') === 'counselor') {
            $sender = $counselor;
            $receiver = $conversation->user;
        } else {
            $sender = $conversation->user;
            $receiver = $counselor;
        }
    
        // Create a new message
        $newMessage = $message->create([
            'conversation_id' => $request->input('conversation_id'),
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'sender_type' => $request->input('sender_type'),
            'read' => false,
            'content' => $request->input('content'),
            'type' => 'text',
        ]);
    
        // Broadcast the message to the other participant(s)
        event(new MessageSent($sender, $newMessage, $conversation));
    
        return response()->json([
            'message' => $newMessage,
        ], 200);
    }
    
}
