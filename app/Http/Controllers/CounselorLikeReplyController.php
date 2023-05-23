<?php

namespace App\Http\Controllers;

use App\Models\LikeReply;
use App\Models\LikeComment;
use Illuminate\Http\Request;
use App\Models\CounselorLikePost;
use App\Models\CounselorLikeReply;
use App\Models\CounselorLikeComment;

class CounselorLikeReplyController extends Controller
{
    public function likeReply($pid, $cid, $rid){
        $ifliked = CounselorLikeReply::where('counselor_id', auth()->user()->id)->
                                where('post_id', $pid)->
                                where('comment_id', $cid)->
                                where('reply_id', $rid)->
                                first();

        if($ifliked){
            CounselorLikeReply::where('counselor_id', auth()->user()->id)
                ->where('post_id', $pid)
                ->where('comment_id', $cid)
                ->where('reply_id', $rid)
                ->first()
                ->delete();

            $response = [
                'message' => 'Unliked!'
            ];
            return response()->json($response, 200);
        }
        else{
            CounselorLikeReply::Create([
                'post_id' => $pid,
                'comment_id' => $cid,
                'reply_id' => $rid,
                'counselor_id' => auth()->user()->id,
            ]);

            $response = [
                'message' => 'Liked!'
            ];
            return response()->json($response, 200);
        }
    }

    public function allPostLikes($id){
        $postLikes = CounselorLikePost::where('post_id', $id)->get();
        $postLikesCount = $postLikes->count();

        $response = [
            "PostLikes" => $postLikes,
            "PostLikesCount" => $postLikesCount
        ];

        return response()->json($response, 200);
    }

    public function allCommentLikes($id){
        $commentAnonLikes = LikeComment::where('comment_id', $id)->get();
        $commentCounselorLikes = CounselorLikeComment::where('comment_id', $id)->get();
        $commentLikesCount = $commentAnonLikes->count() + $commentCounselorLikes->count();

        $response = [
            "CommentAnonLikes" => $commentAnonLikes,
            "CommentCounselorLikes" => $commentCounselorLikes,
            "CommentLikesCount" => $commentLikesCount
        ];


        return response()->json($response, 200);
    }

    public function allReplyLikes($id){
        $replyAnonLikes = LikeReply::where('reply_id', $id)->get();
        $replyCounselorLikes = CounselorLikeReply::where('reply_id', $id)->get();
        $replyLikesCount = $replyAnonLikes->count() + $replyCounselorLikes->count();

        $response = [
            "ReplyAnonLikes" => $replyAnonLikes,
            "ReplyCounselorLikes" => $replyCounselorLikes,
            "CommentLikesCount" => $replyLikesCount
        ];

        return response()->json($response, 200);
    }
}
