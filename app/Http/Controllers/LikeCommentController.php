<?php

namespace App\Http\Controllers;

use App\Models\LikeComment;
use Illuminate\Http\Request;

class LikeCommentController extends Controller
{
    public function likeComment($pid, $cid){
        $ifliked = LikeComment::where('user_id', auth()->user()->id)
            ->where('post_id', $pid)
            ->where('comment_id', $cid)
            ->first();

        if($ifliked){
            LikeComment::where('user_id', auth()->user()->id)
                ->where('post_id', $pid)
                ->where('comment_id', $cid)
                ->first()
                ->delete();

            $response = [
                "message" => "Comment unliked!"
            ];

            return response()->json($response, 200);
        }
            LikeComment::Create([
                'post_id' => $pid,
                'comment_id' => $cid,
                'user_id' => auth()->user()->id,
            ]);

        $response = [
            "message" => "Comment liked!"
        ];

        return response()->json($response, 201);
    }
}
