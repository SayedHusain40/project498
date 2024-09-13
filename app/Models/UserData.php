<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $fillable = [
        'name',
        'role',
        'email',
    ];

    protected $visible = [
        'id',
        'name',
        'role',
        'email',
        'created_at',
    ];
}
