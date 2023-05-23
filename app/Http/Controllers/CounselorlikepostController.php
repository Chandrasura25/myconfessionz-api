<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselorLikePost;

class CounselorlikepostController extends Controller
{
    public function likePost($id){

        $likedpost = CounselorLikePost::where('counselor_id', auth()->user()->id)
            ->where('post_id', $id)
            ->first();

        if($likedpost){
            CounselorLikePost::where('counselor_id', auth()->user()->id)
                ->where('post_id', $id)
                ->first()
                ->delete();

            $response = [
                "message" => "Post unliked!"
            ];

            return response()->json($response, 200);
        }

        $formFields = ([
            'post_id' => $id,
            'counselor_id' => auth()->user()->id
        ]);

        CounselorLikePost::create($formFields);

        $response = [
            "message" => "Post liked!"
        ];

        return response()->json($response, 201);
    }
}
