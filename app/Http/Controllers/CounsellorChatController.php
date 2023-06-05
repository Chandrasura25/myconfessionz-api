<?php

namespace App\Http\Controllers;

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

    return response()->json($messages,200);
}
}
