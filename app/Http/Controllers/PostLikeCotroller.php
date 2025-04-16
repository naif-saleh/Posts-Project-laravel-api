<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostLikeCotroller extends Controller
{
    //Like Post
    public function likePost(Request $request)
    {
        //Validate Request Data
        $validate = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
        ]);

        //Check Validated Date
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
                'code' => 422,
            ]);
        }
        //Create Like
        $like = Like::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ]);
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Post Liked Successfully',
            'like' => $like,
            'code' => 201,
        ]);
    }

    //Unlike Post
    public function unlikePost(Request $request)
    {
        //Validate Request Data
        $validate = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
        ]);

        //Check Validated Date
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
                'code' => 422,
            ]);
        }
        //Delete Like
        Like::where('post_id', $request->post_id)
            ->where('user_id', auth()->user()->id)
            ->delete();
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Post Unliked Successfully',
            'code' => 200,
        ]);
    }
}
