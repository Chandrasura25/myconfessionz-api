<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function reply(Request $request, $id){
        $request->validate([
            'reply' => "required"
        ]);

        $formFields = ([
            "user_id" => auth()->user()->id,
            "comment_id" => $id,
            "reply" => $request->reply
        ]);

        Reply::create($formFields);

        $response = [
            "message" => "replied!"
        ];

        return response()->json([$response], 201);
    }

    public function allCommentReplies($id){
        $commentReplies = Reply::where("comment_id", $id)->get();
        $commentRepliesCount = Reply::where("comment_id", $id)->get()->count();

        $response = [
            "commentReplies" => $commentReplies,
            "commentRepliesCount" => $commentRepliesCount,
        ];

        return response()->json($response, 200);
    }

    public function deleteReply($id){
        $user = Reply::where('id', $id)->first();

        if($user->user_id != auth()->user()->id){
            $response = [
                "message" => "Unauthorized action"
            ];
            return response()->json($response, 401);
        }
        Reply::destroy($id);

        $response = [
            "message" => "deleted!"
        ];
        return response()->json($response, 200);
    }
}
