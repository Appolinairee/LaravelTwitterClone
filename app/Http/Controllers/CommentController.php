<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Ideas $idea, Request $request){

        $validated = $request->validate([
            'content'  => ['required', 'min:5', 'max:10000'],
        ]);

        if(!Auth::user())
            return redirect()->route('login');

        Comment::create([
            'idea_id' => $idea->id,
            'user_id' => Auth::user()->id,
            'content'=> $request->content,
        ]);
        
        return redirect()->route('idea.show', $idea->id)->with('success', 'Comment posted successfully!');
    }
}
