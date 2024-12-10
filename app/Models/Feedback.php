<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Use guarded for mass assignment protection
    protected $guarded = [];

    /**
     * Get the user who submitted the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
