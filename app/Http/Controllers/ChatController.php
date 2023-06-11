<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Counselor;
use App\Models\Conversation;
use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function initiateConversation(Request $request)
    {
        $counselorId = $request->input('counselor_id');
        $userId = Auth::id();

        // Check if a conversation already exists between the user and counselor
        $conversation = Conversation::where('sender_id', $userId)
            ->where('receiver_id', $counselorId)
            ->first();

        if (!$conversation) {
            // Create a new conversation
            $conversation = Conversation::create([
                'sender_id' => $userId,
                'receiver_id' => $counselorId,
                'last_time_message' => now(),
            ]);

            // Send the initial message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $userId,
                'receiver_id' => $counselorId,
                'sender_type' => 'user',
                'read' => false,
                'content' => $request->input('message'),
                'type' => 'text',
            ]);

            return response()->json([
                'conversation' => $conversation,
                'message' => $message,
            ], 200);
        } else {
            // Conversation already exists, return the existing conversation
            return response()->json([
                'conversation' => $conversation,
            ], 200);
        }
    }
    // public function sendReply(Request $request)
    // {
    //     $user = Auth::user();
    //     $counselor = $user->counselor;
    //     $content = $request->input('content');

    //     if ($counselor) {
    //         $conversation = Conversation::where('sender_id', $counselor->id)
    //             ->where('receiver_id', $user->id)
    //             ->first();

    //         if ($conversation) {
    //             $message = Message::create([
    //                 'conversation_id' => $conversation->id,
    //                 'sender_id' => $counselor->id,
    //                 'receiver_id' => $user->id,
    //                 'sender_type' => 'counselor',
    //                 'read' => false,
    //                 'content' => $content,
    //                 'type' => 'text',
    //             ]);

    //             $conversation->update(['last_time_message' => now()]);

    //             return response()->json([
    //                 'message' => $message,
    //             ], 200);
    //         } else {
    //             // Conversation does not exist, handle the error
    //             return response()->json(['error' => 'Conversation not found'], 404);
    //         }
    //     } else {
    //         // User is not associated with a counselor, handle the error
    //         return response()->json(['error' => 'User is not associated with a counselor'], 404);
    //     }
    // }


    // public function getMessages()
    // {
    //     $user = auth()->user(); // Retrieve the authenticated user

    //     // Retrieve the messages where the User is either the sender or recipient
    //     $messages = Message::where(function ($query) use ($user) {
    //         $query->where('user_id', $user->id)
    //             ->orWhere('counselor_id', $user->id);
    //     })->with('user', 'counselor')
    //         ->get();

    //     return response()->json($messages, 200);
    // }
    public function sendMessage(Request $request)
{
    $user = Auth::user();
    $counselorId = $request->input('counselor_id');
    $content = $request->input('content');

    // Check if a conversation already exists between the user and counselor
    $conversation = Conversation::where('sender_id', $user->id)
        ->where('receiver_id', $counselorId)
        ->first();

    // If no conversation exists, create a new one
    if (!$conversation) {
        $conversation = Conversation::create([
            'sender_id' => $user->id,
            'receiver_id' => $counselorId,
            'last_time_message' => now(),
        ]);
    }

    // Create a new message
    $message = Message::create([
        'conversation_id' => $conversation->id,
        'sender_id' => $user->id,
        'receiver_id' => $counselorId,
        'sender_type' => 'user',
        'read' => false,
        'content' => $content,
        'type' => 'text',
    ]);

    // Fire the event for the new message sent
    event(new MessageSent($user, $message, $conversation));

    return response()->json([
        'message' => 'Message sent successfully',
    ], 200);
}



}
