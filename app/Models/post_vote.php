<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post_vote extends Model
{
    use HasFactory;

    protected $table = 'post_likes';
}
