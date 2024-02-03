<?php

namespace App\Http\Controllers;

use App\Models\Ideas;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function follow($userId){
        $follower = auth()->user();
        if($follower->isFollowing($user = User::find($userId))){
            $follower->following()->detach($userId);
            $message = "you unfollow succesfully";
        }else{
            $follower->following()->attach($userId);
            $message = "you follow succesfully";
        }

        return redirect()->route('users.show',  $userId)->with('success', $message);
    }

    public function like(Ideas $idea){
        $user = auth()->user();

        if($user->isLiked($idea)){
            $user->likes()->detach($idea->id);
            $message = "you unlike successfully";
        }else{
            $user->likes()->attach($idea->id);
            $message = "you like successfully";
        }

        return redirect()->route('idea.show', $idea->id)->with('success', $message);
    }
}