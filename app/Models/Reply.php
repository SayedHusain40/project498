<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function likesDislikes()
    {
        return $this->hasMany(ReplyUserLikeDislike::class);
    }


    public function likedByUser($userId)
    {
        return $this->likesDislikes()->where('user_id', $userId)->where('type', 'like')->exists();
    }

    public function dislikedByUser($userId)
    {
        return $this->likesDislikes()->where('user_id', $userId)->where('type', 'dislike')->exists();
    }

}
