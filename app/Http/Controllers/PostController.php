<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // All Posts
    public function index()
    {
        // Fetch all posts from the database
        $posts = Post::with('user', 'category', 'comments', 'likes', 'dislikes')->paginate(20);
        $count = Post::count();

        // Return the posts as a JSON response
        return response()->json([

            'Status' => true,
            'Message' => 'All Posts',
            'Posts' => $posts,
            'Post_Count' => $count,
            'code' => 200,
        ]);
    }

    // Create Post
    public function createPost(Request $request)
    {
        // Validate the request data
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        // Check if validation fails
        if ($validate->fails()) {
            return response()->json([
                'Status' => false,
                'Message' => $validate->errors(),
                'code' => 422,
            ]);
        }
        // Check if the image is present in the request
        if ($request->hasFile('image')) {
            // Store the image and get its path
            $imagePath = $request->file('image')->store('images', 'public');
            // Add the image path to the request data
            $request->merge(['image' => $imagePath]);
        }
        // Create a new post
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);
        // Generate a slug for the post
        $post->PostSulg();
        // Save the post
        $post->save();

        // Return the created post as a JSON response
        return response()->json([
            'Status' => true,
            'Message' => 'Post Created Successfully',
            'Post' => $post,
            'code' => 201,
        ]);
    }

    // Single Post
    public function showPost($id)
    {
        // Fetch the post with the given ID
        $post = Post::with('user', 'category', 'comments', 'likes', 'dislikes')->find($id);

        // Check if the post exists
        if (!$post) {
            return response()->json([
                'Status' => false,
                'Message' => 'Post Not Found',
                'code' => 404,
            ]);
        }

        $comments = $post->comments()->with('user')->count();
        $likes = $post->likes()->count();
        $dislikes = $post->dislikes()->count();

        // Return the post as a JSON response
        return response()->json([
            'Status' => true,
            'Message' => 'Post Found',
            'Post' => $post,
            'Comments_count' => $comments,
            'Likes_count' => $likes,
            'Dislikes_count' => $dislikes,
            'code' => 200,
        ]);
    }

    // Update Post
    public function updatePost(Request $request, $id)
    {
        // Fetch the post with the given ID
        $post = Post::find($id);

        // Check if the post exists
        if (!$post) {
            return response()->json([
                'Status' => false,
                'Message' => 'Post Not Found',
                'code' => 404,
            ]);
        }

        // Validate the request data
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        // Check if validation fails
        if ($validate->fails()) {
            return response()->json([
                'Status' => false,
                'Message' => $validate->errors(),
                'code' => 422,
            ]);
        }
        // Check if the image is present in the request
        if ($request->hasFile('image')) {
            // Store the image and get its path
            $imagePath = $request->file('image')->store('images', 'public');
            // Add the image path to the request data
            $request->merge(['image' => $imagePath]);
        }
        // Update the post with the new data
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);
        // Generate a slug for the post
        $post->PostSulg();
        // Save the post
        $post->save();

        // Return the updated post as a JSON response
        return response()->json([
            'Status' => true,
            'Message' => 'Post Updated Successfully',
            'Post' => $post,
            'code' => 200,
        ]);
    }


    // Delete Post
    public function deletePost($id)
    {
        // Fetch the post with the given ID
        $post = Post::find($id);

        // Check if the post exists
        if (!$post) {
            return response()->json([
                'Status' => false,
                'Message' => 'Post Not Found',
                'code' => 404,
            ]);
        }

        // Delete the post
        $post->delete();

        // Return a success message as a JSON response
        return response()->json([
            'Status' => true,
            'Message' => 'Post Deleted Successfully',
            'code' => 200,
        ]);
    }
}
