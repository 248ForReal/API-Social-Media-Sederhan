<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\v1\user\UserController;
use App\Http\Controllers\v1\post\PostController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::prefix('v1')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/me', [UserController::class, 'me']);
            Route::get('/search', [UserController::class, 'search']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::post('/{id}', [UserController::class, 'update']);
            Route::post('/{id}/follow', [UserController::class, 'follow']);
            Route::get('/{id}/follower', [UserController::class, 'followers']);
            Route::get('/{id}/following', [UserController::class, 'following']);
            Route::get('/me/posts', [UserController::class, 'mePosts']);
        });

        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'getAllPosts']);
            Route::get('/{id}', [PostController::class, 'getPostById']);
            Route::post('/', [PostController::class, 'addPost']);
            Route::post('/{id}', [PostController::class, 'editPost']);
            Route::delete('/{id}', [PostController::class, 'deletePost']);
            Route::post('/{postId}/like', [PostController::class, 'likeUnlikePost']);
            Route::post('/{postId}/comment', [PostController::class, 'addComment']);
            Route::delete('/comment/{commentId}', [PostController::class, 'deleteComment']);
        });
    });
});
