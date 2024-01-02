<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function follow($userId){
        $follower = auth()->user();
        $follower->following()->attach($userId);

        return redirect()->route('users.show',  $userId)->with('success', "you're following succesfully");
    }

    public function unfollow(){
        
    }
}