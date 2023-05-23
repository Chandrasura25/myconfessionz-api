<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselorReply;

class CounselorreplyController extends Controller
{
    public function reply(Request $request, $id){
        $request->validate([
            'reply' => "required"
        ]);

        $formFields = ([
            "counselor_id" => auth()->user()->id,
            "comment_id" => $id,
            "reply" => $request->reply
        ]);

        // dd($formFields);

        CounselorReply::create($formFields);

        $response = [
            "message" => "replied!"
        ];

        return response()->json([$response], 201);
    }

    public function allCommentReplies($id){
        $commentReplies = CounselorReply::where("comment_id", $id)->get();
        $commentRepliesCount = CounselorReply::where("comment_id", $id)->get()->count();

        $response = [
            "commentReplies" => $commentReplies,
            "commentRepliesCount" => $commentRepliesCount,
        ];

        return response()->json($response, 200);
    }

    public function deleteReply($id){
        $user = CounselorReply::where('id', $id)->first();

        if($user->counselor_id != auth()->user()->id){
            $response = [
                "message" => "Unauthorized action"
            ];
            return response()->json($response, 401);
        }
        CounselorReply::destroy($id);

        $response = [
            "message" => "deleted!"
        ];
        return response()->json($response, 200);
    }
}
