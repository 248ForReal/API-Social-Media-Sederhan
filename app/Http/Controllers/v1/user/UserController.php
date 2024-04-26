<?php

namespace App\Http\Controllers\v1\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('posts', 'followers', 'following')->with('posts', 'followers', 'following')->get();
        return response()->json(['status' => 'success', 'data' => $users], 200);
    }

    public function show($id)
    {
        $user = User::withCount('posts', 'followers', 'following')->with('posts', 'followers', 'following')->find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $user], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $userWithRelationships = $user->loadCount('posts', 'followers', 'following')->load('posts', 'followers', 'following.posts');
        return response()->json(['status' => 'success', 'data' => $userWithRelationships], 200);
    }




    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        $name = $request->input('name');

        $users = User::with('posts', 'followers')->where('name', 'like', "%$name%")->get();

        return response()->json(['status' => 'success', 'data' => $users], 200);
    }

    public function followers($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        $followers = $user->followers;
        $followersCount = $user->followers()->count();

        return response()->json(['status' => 'success', 'followers_count' => $followersCount, 'followers' => $followers], 200);
    }


    public function following($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        $following = $user->following;
        $followingCount = $user->following()->count();

        return response()->json(['status' => 'success', 'following_count' => $followingCount, 'following' => $following], 200);
    }


    public function follow(Request $request, $id)
    {
        $user = $request->user();
        $followingUser = User::find($id);

        if (!$followingUser) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        if ($user->id === $followingUser->id) {
            return response()->json(['status' => 'error', 'message' => 'You cannot follow yourself'], 400);
        }

        $isFollowing = Follower::where('follower_id', $user->id)
            ->where('following_id', $followingUser->id)
            ->exists();

        if ($isFollowing) {
            Follower::where('follower_id', $user->id)
                ->where('following_id', $followingUser->id)
                ->delete();

            return response()->json(['status' => 'success', 'message' => 'Unfollowed user successfully'], 200);
        } else {
            Follower::create([
                'follower_id' => $user->id,
                'following_id' => $followingUser->id,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Followed user successfully'], 200);
        }
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->id != $id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'newPassword' => 'nullable|min:6',
            'confirmNewPassword' => 'same:newPassword',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('avatars', $avatarName, 'public');
            $user->avatar = 'storage/avatars/' . $avatarName;
        }

        if ($request->filled('newPassword')) {
            $user->password = bcrypt($request->newPassword);
        }


        $user->save();

        return response()->json(['status' => 'success', 'message' => 'User updated successfully', 'data' => $user], 200);
    }



    public function mePosts(Request $request)
    {
        $user = $request->user();
        $userPosts = $user->posts()->with('media')->withCount('likes', 'comments')->get();
        return response()->json(['status' => 'success', 'data' => $userPosts], 200);
    }
}
