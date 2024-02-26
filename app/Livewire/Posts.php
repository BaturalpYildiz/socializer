<?php

namespace App\Livewire;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\post_status;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $query = '';

    public $displayingPost = false;

    public Post|null $postDetails;

    public $postStatuses;

    public int $status = 0;

    public function search()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->postStatuses = post_status::all();
    }

    public function render()
    {
        $posts = Post::when($this->status == 0, function (Builder $query) {
            // als check if posts with the status 1 are only shown to the user who created them
            $query->whereIn('status_id', [2, 3])
                ->orWhere('status_id', 1)
                ->where('user_id', auth()->user()->id);
        })
            ->when($this->status == 1, function (Builder $query) {
                $query->where('status_id', 1)
                    ->where('user_id', auth()->user()->id);
            })
            ->when($this->status > 1, function (Builder $query) {
                $query->where('status_id', $this->status);
            })
            ->when($this->query, function (Builder $query) {
                $query->where('title', 'like', "%{$this->query}%")
                    ->orWhere('content', 'like', "%{$this->query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.posts', [
            'posts' => $posts,
        ]);
    }

    public function showPost(int|string $id)
    {
        $this->displayingPost = true;
        $this->postDetails = Post::find($id);
        // dd($this->post);
        $this->dispatch('displaying-post');
    }

    public function closePost()
    {
        $this->displayingPost = false;
    }

    public function editPost(int|string $id)
    {
        return redirect()->route('posts.edit', $id);
    }

    public function likePost(int|string $id)
    {
        $post = Post::find($id);
        $vote = $post->vote();
        if ($vote->liked == 1) {
            $vote->liked = 0;
            $vote->save();
            return;
        }
        $vote->liked = 1;
        $vote->disliked = 0;
        $vote->save();
    }

    public function dislikePost(int|string $id)
    {
        $post = Post::find($id);
        $vote = $post->vote();
        if ($vote->disliked == 1) {
            $vote->disliked = 0;
            $vote->save();
            return;
        }
        $vote->liked = 0;
        $vote->disliked = 1;
        $vote->save();
    }
}
