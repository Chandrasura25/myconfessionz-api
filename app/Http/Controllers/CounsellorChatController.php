<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
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

    public function sendMessages(Request $request)
    {
        // Validate the request data
        $request->validate([
            'message_id' => 'required',
            'content' => 'required',
        ]);

        // Retrieve the authenticated counselor
        $counselor = auth()->user();

        // Find the message by its ID
        $message = Message::find($request->input('message_id'));

        // Check if the message exists and if the counselor is the recipient
        if ($message && $message->counselor_id == $counselor->id) {
            // Update the message with the counselor's reply
            $message->reply = $request->input('content');
            $message->save();

            // Broadcast the message sent event
            broadcast(new MessageSent($message))->toOthers();

            // Return a JSON response with the updated message
            return response()->json($message, 201);
        }

        // Return an error response if the message does not exist or the counselor is not the recipient
        return response()->json(['error' => 'Invalid message or unauthorized.'], 403);
    }

}
