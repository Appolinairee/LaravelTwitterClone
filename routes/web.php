<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\IdeasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IdeasController::class, 'index'])->name('welcome');

Route::group(['prefix' => 'idea/', 'as' => 'idea.'], function () {
    Route::post('', [IdeasController::class, 'store'])->name('store');

    Route::get('/{idea}', [IdeasController::class, 'show'])->name('show');

    Route::group(['middleware' => ['auth']], function (){
        Route::get('/{idea}/edit', [IdeasController::class, 'edit'])
            ->name('edit');

        Route::put('/{idea}/edit', [IdeasController::class, 'update'])
            ->name('update');

        Route::delete('/{idea}', [IdeasController::class, 'destroy'])
            ->name('destroy');
    });

    Route::post('/{idea}/comment', [CommentController::class, 'store'])->name('comment.store');
});

Route::resource('users', UserController::class)->only('edit', 'show', 'update')->middleware('auth');

Route::post('users/{user}/follow', [FollowerController::class, 'follow'])->middleware('auth')->name('users.follow');

Route::post('users/{idea}/like', [FollowerController::class, 'like'])->middleware('auth')->name('idea.like');

Route::get('/feed', FeedController::class)->middleware('auth')->name('feed');

Route::get('/terms', function () {
    return view('terms');
})->name("terms");

Route::get('/admin', [AdminController::class, 'show'])->middleware(['auth', 'isAdmin'])->name('admin.dashboard');