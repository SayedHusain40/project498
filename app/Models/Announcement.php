<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'event_date' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
