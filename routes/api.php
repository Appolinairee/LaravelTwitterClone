<?php

use App\Models\Ideas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API
|
*/

Route::get('posts', [PostController::class, 'index']);
Route::get('users', function() {
    return User::all();
});


Route::post('/users/register', [ApiUserController::class, 'register']);
Route::post('/users/login', [ApiUserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return response()->json(request()->user());
    });

    Route::post('posts/create', [PostController::class, 'store']);
    Route::put('posts/update/{post}', [PostController::class, 'update']);
    Route::delete('posts/delete/{post}', [PostController::class, 'delete']);
});