<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counselorcomment;

class CounselorcommentController extends Controller
{
    public function counselorcomment(Request $request, $id){
        $request->validate([
            "comment" => 'required'
        ]);

        $formFields = ([
            "post_id" => $id,
            "counselor_id" => auth()->user()->id,
            "comment" => $request->comment,
            'category' => $request->category,
        ]);

        Counselorcomment::create($formFields);

        $response = [
            "message" => "Advice shared!"
        ];

        return response()->json($response, 201);
    }

    public function allPostComments($id){
        $postComments = Counselorcomment::where("post_id", $id)->get();
        $postCommentsCount = Counselorcomment::where("post_id", $id)->get()->count();

        $response = [
            "PostComments" => $postComments,
            "PostCommentsCount" => $postCommentsCount
        ];

        return response()->json($response, 200);
    }


    public function deleteComment($id){
        $counselor = Counselorcomment::where('id', $id)->first();

        if($counselor->counselor_id != auth()->user()->id){
            $response = [
                "message" => "Unauthorized action"
            ];
            return response()->json($response, 401);
        }
        Counselorcomment::destroy($id);

        $response = [
            "message" => "Comment deleted!"
        ];
        return response()->json($response, 200);
    }
}
