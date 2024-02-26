<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post_status extends Model
{
    use HasFactory;

    protected $table = 'posts_status';
    protected $fillable = ['name'];
    public $timestamps = true;
}
