<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(User $user)
    {
        $ideas = $user->ideas()->paginate(5);
        return view('users.show', compact('user', 'ideas'));
    }

    public function edit(User $user)
    {
        $ideas = $user->ideas()->paginate(5);
        $editing = true;
        return view('users.edit', compact('user', 'editing', 'ideas'));
    }

    public function update(User $user, Request $request)
    {
        if (Auth::id() != $user->id) {
            abort(403);
        }       

        if ($request->isMethod('put')){
            $validated = $request->validate([
                'name' => ['nullable', 'min:5', 'max:40'],
                'image' => ['nullable','image', 'mimes:jpeg,png,jpg,gif', 'max: 2048'],
                'bio' => ['nullable', 'min:5', 'max:300']
            ]);
    
            if($request->has('image')){
                $imagePath = request()->file('image')->store('profile', 'public');
                $validated['image'] = $imagePath;
                Storage::disk('public')->delete($user->image?? '');

            }
    
            $user->update($validated);
            $ideas = $user->ideas()->paginate(5);
            return view('users.show', compact('user', 'ideas'));
        }
    }

}
