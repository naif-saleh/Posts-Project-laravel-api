<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostCommentsCotroller extends Controller
{
    //Get All Comments
    public function index()
    {
        //Get Comments Paginated
        $comments = Comment::with('user', 'post')->paginate(10);
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'All Comments',
            'comments' => $comments,
            'code' => 200,
        ]);
    }


    //Create Comment
    public function createComment(Request $request)
    {
        //Validate Request Data
        $validate = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
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
        //Create Comment
        $comment = Comment::create([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ]);
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Comment Created Successfully',
            'comment' => $comment,
            'code' => 201,
        ]);
    }

    //Show Comment
    public function showComment($id)
    {
        //Find Comment
        $comment = Comment::with('user', 'post')->find($id);
        //Check if Comment Exists
        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'Comment Not Found',
                'code' => 404,
            ]);
        }
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Comment Found',
            'comment' => $comment,
            'code' => 200,
        ]);
    }

    //Update Comment
    public function updateComment(Request $request, $id)
    {
        //Validate Request Data
        $validate = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
        ]);

        //Check Validated Date
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
                'code' => 422,
            ]);
        }
        //Find Comment
        $comment = Comment::find($id);
        //Check if Comment Exists
        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'Comment Not Found',
                'code' => 404,
            ]);
        }
        //Update Comment
        $comment->update([
            'content' => $request->content,
        ]);
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Comment Updated Successfully',
            'comment' => $comment,
            'code' => 200,
        ]);
    }

    //Delete Comment
    public function deleteComment($id)
    {
        //Find Comment
        $comment = Comment::find($id);
        //Check if Comment Exists
        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'Comment Not Found',
                'code' => 404,
            ]);
        }
        //Delete Comment
        $comment->delete();
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Comment Deleted Successfully',
            'code' => 200,
        ]);
    }

}
