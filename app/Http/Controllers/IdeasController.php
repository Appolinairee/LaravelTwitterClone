<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ideas;
use Illuminate\Support\Facades\Auth;

class IdeasController extends Controller
{
    public function index()
    {
        $ideas = Ideas::orderBy('created_at', 'DESC');

        if (request()->has('search')) {
            $ideas = $ideas->where('content', 'like', '%' . request()->get('search', '') . '%');
        }

        return view('welcome', [
            'ideas' => $ideas->paginate(5),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'min:5', 'max:10000'],
        ]);

        if(!Auth::user()) {
            return redirect()->route('login');
        }

        Ideas::create([
            'user_id' => Auth::user()->id,
            'content' => $request->content,
        ]);

        return redirect()
            ->route('welcome')
            ->with('success', 'Idea is posted successfully');
    }

    public function show(Ideas $idea)
    {
        return view('card', compact('idea'));
    }

    public function edit(Ideas $idea)
    {
        if (Auth::id() !== $idea->user_id) {
            abort(403, 'You are not allowed to edit');
        }

        $editing = true;
        return view('card', compact('idea', 'editing'));
    }

    public function update(Request $request, Ideas $idea)
    {
        if (Auth::id() !== $idea->user_id) {
            abort(403);
        }

        $request->validate([
            'content' => ['required', 'min:5', 'max:10000', 'unique:ideas'],
        ]);

        $idea->content = $request->get('content');
        $idea->save();

        return redirect()
            ->route('idea.show', $idea->id)
            ->with('success', 'Idea updated successfully');
    }

    public function destroy(Ideas $idea)
    {
        $idea->delete();
        return redirect()
            ->route('welcome')
            ->with('success', 'Idea is deleted successfully');
    }
}
