<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request) {
        try {
            $query = Post::query();

            $perPage = 10;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search)
                $search = $request->search("title LIKE '%" .$search. "%'");

            $total = $query->count();
            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'statut_code' => 200,
                'statut_message' => 'Les posts ont été récupérés',
                'currentPage' => $page,
                'lastPageIndex' => ceil($total / $perPage),
                'data' => $result
            ]);
            
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreatePostRequest $request) {
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->user_id = auth()->user()->id;
            $post->save();

            return response()->json([
                'statut_code' => 200,
                'statut_message' => 'Le post est créé',
                'data' => $post,
            ]);
   
        }catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(EditPostRequest $request, Post $post) {
        try {
            if($post->user_id == auth()->user()->id){
                $dataToUpdate = $request->only(['title', 'content']);

                $post->update($dataToUpdate);

                return response()->json([
                    'statut_code' => 200,
                    'statut_message' => 'Le post est modifié avec succès',
                    'data' => $post
                ]);
            }else{
                return response()->json([
                    'statut_code' => 422,
                    'statut_message' => 'Vous n\'êtes pas l\'auteur de ce post.',
                ]);
            }

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function delete(Post $post){
        try {
            if($post->user_id == auth()->user()->id){
                $post->delete();

                return response()->json([
                    'statut_code' => 200,
                    'statut_message' => 'Le post est supprimé',
                    'data' => $post
                ]);
            }else{
                return response()->json([
                    'statut_code' => 422,
                    'statut_message' => 'Vous n\'êtes pas l\'auteur de ce post.'
                ]);
            }

        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
