<?php

namespace App\Http\Controllers;

use App\Models\Anoncomment;
use App\Models\Counselorcomment;
use App\Models\CounselorLikePost;
use App\Models\LikePost;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function createPost(Request $request){
        $request->validate([
            'post' => 'required',
            'category' => 'required|string'
        ]);

        $formFields = ([
            'user_id' => auth()->user()->id,
            'post' => $request->post,
            'category' => $request->category
        ]);

        $post = Post::create($formFields);

        $response = [
            "message" => $post
        ];

        return response()->json($response, 201);
    }

    public function singlePost($id){
        $post = Post::find($id);
        $anonComments = Anoncomment::where('post_id', $id)->latest()->get();
        $counselorComments = Counselorcomment::where('post_id', $id)->latest()->get();
        $anonPostLikes = LikePost::where('post_id', $id)->get();
        $counselorPostLikes = CounselorLikePost::where('post_id', $id)->get();
        $allComments = Anoncomment::where('post_id', $id)->latest()->get()->count() + Counselorcomment::where('post_id', $id)->latest()->get()->count();
        $allPostLikes = $anonPostLikes->count() + $counselorPostLikes->count();

        $response = [
            "post" => $post,
            "anonComments" => $anonComments,
            "counselorComments" => $counselorComments,
            "anonLikes" => $anonPostLikes,
            "counselorLikes" => $counselorPostLikes,
            "allLikes" => $allPostLikes,
            "allComments" => $allComments
        ];

        return response()->json($response, 200);
    }

    public function allPostsHome(){
        $posts = Post::orderBy('created_at', 'desc')->limit(10)->get();
        $anonComments = Anoncomment::all();
        $counselorComments = Counselorcomment::all();
        $anonLikes = LikePost::all();
        $counselorLikes = CounselorLikePost::all();

        $response = [
            "posts" => $posts,
            "anonComments" => $anonComments,
            "counselorComments" => $counselorComments,
            "anonLikes" => $anonLikes,
            "counselorLikes" => $counselorLikes,
        ];

        return response()->json($response, 200);
    }

    public function allPostsExplore(){
        $posts = $posts = Post::inRandomOrder()->limit(5)->get();
        $anonComments = Anoncomment::all();
        $counselorComments = Counselorcomment::all();
        $anonLikes = LikePost::all();
        $counselorLikes = CounselorLikePost::all();

        $response = [
            "posts" => $posts,
            "anonComments" => $anonComments,
            "counselorComments" => $counselorComments,
            "anonLikes" => $anonLikes,
            "counselorLikes" => $counselorLikes,
        ];

        return response()->json($response, 200);
    }

    public function deletePost($id){
        $user = Post::where('id', $id)->first();
        if($user->user_id != auth()->id()){
            $response = [
                "message" => "Unauthorized action"
            ];
            return response()->json($response, 401);
        }
        Post::destroy($id);

        $response = [
            "message" => "Confession deleted!"
        ];
        return response()->json($response, 200);
    }
}
