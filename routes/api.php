<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostCommentsCotroller;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostDislikeCotroller;
use App\Http\Controllers\PostLikeCotroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //Category Routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'createCategory']);
    Route::get('/categories/{id}', [CategoryController::class, 'showCategory']);
    Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

    //Posts Routes
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'createPost']);
    Route::get('/posts/{id}', [PostController::class, 'showPost']);
    Route::put('/posts/{id}', [PostController::class, 'updatePost']);
    Route::delete('/posts/{id}', [PostController::class, 'deletePost']);

    //Comments Routes
    Route::get('/comments', [PostCommentsCotroller::class, 'index']);
    Route::post('/comments', [PostCommentsCotroller::class, 'createComment']);
    Route::get('/comments/{id}', [PostCommentsCotroller::class, 'showComment']);
    Route::put('/comments/{id}', [PostCommentsCotroller::class, 'updateComment']);
    Route::delete('/comments/{id}', [PostCommentsCotroller::class, 'deleteComment']);

    //Like && Unlike Post
    Route::post('/posts/like', [PostLikeCotroller::class, 'likePost']);
    Route::post('/posts/unlike', [PostLikeCotroller::class, 'unlikePost']);

    //Dislike && Unlike Post
    Route::post('/posts/dislike', [PostDislikeCotroller::class, 'dislikePost']);
    Route::post('/posts/undislike', [PostDislikeCotroller::class, 'undislikePost']);
    
    //Logout Route
    Route::post('/logout', [AuthController::class, 'logout']);
});

