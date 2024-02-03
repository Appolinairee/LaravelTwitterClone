<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'bio',
        'image',
        'password',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ideas(){
        return $this->hasMany(Ideas::class)->latest();
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function getImage() {
        if($this->image){
            return url('storage/'. $this->image);
        }
        
        return "https://api.dicebear.com/6.x/fun-emoji/svg?seed={$this->name}";
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'follower_user', 'user_id', 'follower_id')->withTimestamps();
    }

    public function following(){
        return $this->belongsToMany(User::class, 'follower_user', 'follower_id', 'user_id')->withTimestamps();
    }

    public function isFollowing(User $user){
        return $this->following()->where('user_id', $user->id)->exists();
    }

    public function userToFollow($perPage = 10){
        $allUsers = User::where('id', '!=', $this->id)->paginate($perPage);
    
        $usersToFollow = $allUsers->reject(function ($otherUser) {
            return $this->isFollowing($otherUser);
        });

        return $allUsers;
    }

    public function likes(){
        return $this->belongsToMany(Ideas::class, 'idea_likes', 'user_id', 'idea_id')->withTimestamps();
    }

    public function isLiked(Ideas $idea){
        return $this->likes()->where('idea_id', $idea->id)->exists();
    }
}