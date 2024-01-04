<?php

namespace App\Http\Controllers;

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

    public function unfollow(){
        
    }
}