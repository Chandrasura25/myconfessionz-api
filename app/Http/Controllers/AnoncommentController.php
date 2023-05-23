<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Anoncomment;
use Illuminate\Http\Request;

class AnoncommentController extends Controller
{
    public function anonComment(Request $request, $id){
        $request->validate([
            "comment" => 'required'
        ]);

        $formFields = ([
            "post_id" => $id,
            "user_id" => auth()->user()->id,
            "comment" => $request->comment,
            'category' => $request->category,
        ]);

        Anoncomment::create($formFields);

        $response = [
            "message" => "Comment shared!"
        ];

        return response()->json($response, 201);
    }

    public function allPostComments($id){
        $postComments = Anoncomment::where("post_id", $id)->get();
        $postCommentsCount = Anoncomment::where("post_id", $id)->get()->count();
        $commentReplies = Reply::all();
        $commentRepliesCount = Reply::all()->count();

        $response = [
            "PostComments" => $postComments,
            "PostCommentsCount" => $postCommentsCount,
            "commentReplies" => $commentReplies,
            "commentRepliesCount" => $commentRepliesCount
        ];

        return response()->json($response, 200);
    }

    public function deleteComment($id){
        $user = Anoncomment::where('id', $id)->first();

        if($user->user_id != auth()->user()->id){
            $response = [
                "message" => "Unauthorized action"
            ];
            return response()->json($response, 401);
        }
        Anoncomment::destroy($id);

        $response = [
            "message" => "Comment deleted!"
        ];
        return response()->json($response, 200);
    }
}
