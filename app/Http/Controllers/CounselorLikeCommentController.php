<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselorLikeComment;

class CounselorLikeCommentController extends Controller
{
    public function likeComment($pid, $cid){
        $ifliked = CounselorLikeComment::where('counselor_id', auth()->user()->id)
            ->where('post_id', $pid)
            ->where('comment_id', $cid)
            ->first();
        if($ifliked){
            CounselorLikeComment::where('counselor_id', auth()->user()->id)
            ->where('post_id', $pid)
            ->where('comment_id', $cid)
            ->first()
            ->delete();

            $response = [
                "message" => "Comment unliked!"
            ];

            return response()->json($response, 200);
        }
            CounselorLikeComment::Create([
                'post_id' => $pid,
                'comment_id' => $cid,
                'counselor_id' => auth()->user()->id,
            ]);

        $response = [
            "message" => "Comment liked!"
        ];

        return response()->json($response, 201);
    }
}
