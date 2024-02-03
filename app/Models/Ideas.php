<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    use HasFactory;

    protected $with = ['user', 'comments.user'];

    protected $fillable = [
        'user_id',
        'content',
        'likes',
    ];

    public function comments(){
        return $this->hasMany(Comment::class, 'idea_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'idea_likes', 'idea_id', 'user_id')->withTimestamps();
    }

}