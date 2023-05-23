<?php

namespace App\Http\Controllers;

use App\Models\LikePost;
use Illuminate\Http\Request;

class AnonlikepostController extends Controller
{
    public function likePost($id){
        $likedpost = LikePost::where('user_id', auth()->user()->id)->where('post_id', $id)->first();

        if($likedpost){
            LikePost::where('user_id', auth()->user()->id)->where('post_id', $id)->first()->delete();

            $response = [
                "message" => "Post unliked!"
            ];

            return response()->json($response, 200);
        }

        $formFields = ([
            'post_id' => $id,
            'user_id' => auth()->user()->id
        ]);

        LikePost::create($formFields);

        $response = [
            "message" => "Post liked!"
        ];

        return response()->json($response, 201);
    }
}
