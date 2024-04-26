<?php

namespace App\Http\Controllers\v1\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Media;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('posts', 'public');

                $media = new Media([
                    'post_id' => $post->id,
                    'image' => $path,
                ]);
                $media->save();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Post created successfully', 'data' => $post], 201);
    }


    public function editPost(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['status' => 'error', 'message' => 'Post not found'], 404);
        }


        if ($post->user_id !== auth()->id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        $post->content = $request->content;
        $post->save();


        $media = Media::where('post_id', $post->id)->get();
        foreach ($media as $m) {
            Storage::disk('public')->delete($m->image);
        }
        Media::where('post_id', $post->id)->delete();


        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('posts', 'public');

                $media = new Media([
                    'post_id' => $post->id,
                    'image' => $path,
                ]);
                $media->save();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Post updated successfully', 'data' => $post], 200);
    }



    public function getAllPosts(Request $request)
    {

        $posts = Post::with(['media', 'comments', 'likes'])->get();


        $posts->each(function ($post) {
            $post->comment_count = $post->comments->count();
            $post->like_count = $post->likes->count();


            $post->comments->each(function ($comment) {
                $comment->load('user');
            });

            $post->likes->each(function ($like) {
                $like->load('user');
            });
        });

        return response()->json(['status' => 'success', 'data' => $posts], 200);
    }


    public function getPostById($id)
    {
        $post = Post::with(['media', 'comments', 'likes'])->find($id);

        if (!$post) {
            return response()->json(['status' => 'error', 'message' => 'Post not found'], 404);
        }


        $post->comment_count = $post->comments->count();
        $post->like_count = $post->likes->count();


        $post->comments->each(function ($comment) {
            $comment->load('user');
        });

        $post->likes->each(function ($like) {
            $like->load('user');
        });

        return response()->json(['status' => 'success', 'data' => $post], 200);
    }

    public function likeUnlikePost($postId)
    {
        $userId = auth()->id();

        $like = Like::where('user_id', $userId)->where('post_id', $postId)->first();

        if ($like) {
            $like->delete();
            return response()->json(['status' => 'success', 'message' => 'Post unliked successfully'], 200);
        } else {
            $like = Like::create([
                'user_id' => $userId,
                'post_id' => $postId,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Post liked successfully', 'data' => $like], 201);
        }
    }



    public function addComment(Request $request, $postId)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        $comment = new Comment([
            'user_id' => auth()->id(),
            'post_id' => $postId,
            'content' => $request->content,
        ]);
        $comment->save();

        return response()->json(['status' => 'success', 'message' => 'Comment added successfully', 'data' => $comment], 201);
    }



    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) {
            return response()->json(['status' => 'error', 'message' => 'Comment not found'], 404);
        }
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $comment->delete();

        return response()->json(['status' => 'success', 'message' => 'Comment deleted successfully'], 200);
    }






}
