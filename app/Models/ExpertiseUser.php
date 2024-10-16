<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertiseUser extends Model
{
    use HasFactory;
    protected $table = 'expertise_user';
    protected $guarded = [];
}
