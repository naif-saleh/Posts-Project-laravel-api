<?php

namespace App\Http\Controllers;

use App\Models\Dislike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostDislikeCotroller extends Controller
{
    //Dislike Post
    public function dislikePost(Request $request)
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
        //Create Dislike
        $dislike = Dislike::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ]);
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Post Disliked Successfully',
            'dislike' => $dislike,
            'code' => 201,
        ]);
    }

    //Undislike Post
    public function undislikePost(Request $request)
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
        //Delete Dislike
        Dislike::where('post_id', $request->post_id)
            ->where('user_id', auth()->user()->id)
            ->delete();

        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Post Undisliked Successfully',
            'code' => 200,
        ]);
    }
}
