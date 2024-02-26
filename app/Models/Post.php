<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(post_status::class);
    }

    public function vote(int|string|null $user_id = 0)
    {
        if (empty($user_id)) {
            $user_id = auth()->user()->id;
        }
        $foundPostVote = post_vote::where('post_id', $this->id)->where('user_id', $user_id)->first();
        // if nothing was found, create a new vote with no like or dislike
        if (empty($foundPostVote)) {
            $newVote = new post_vote();
            $newVote->post_id = $this->id;
            $newVote->user_id = $user_id;
            $newVote->liked = 0;
            $newVote->disliked = 0;
            $newVote->save();
            return $this->vote();
        }
        return $foundPostVote;
    }
}
