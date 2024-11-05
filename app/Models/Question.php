<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function replyCount()
    {
        return $this->replies()->count();
    }

    public function likesDislikes()
    {
        return $this->hasMany(QuestionUserLikeDislike::class);
    }

}
