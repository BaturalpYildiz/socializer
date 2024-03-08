<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friends extends Model
{
    use HasFactory;
    // table is friends
    protected $table = 'friends';
    // primary key is id
    protected $primaryKey = 'id';

    // fields
    protected $fillable = [
        'friend1_id',
        'friend2_id',
    ];

    public function getFriendsOfUser(int $userId)
    {
        return $this->where('friend1_id', $userId)->orWhere('friend2_id', $userId)->get();
    }
}
