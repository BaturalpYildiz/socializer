<?php

namespace App\Livewire;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\post_status;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $query = '';

    public $displayingPost = false;

    public Post|null $postDetails;


    public function search()
    {
        $this->resetPage();
    }

    public function mount()
    {
    }

    public function render()
    {
        $posts = Post::whereTitle($this->query)
            ->orWhere('content', 'like', "%{$this->query}%")
            ->where('status_id', '!=', post_status::first()->id)
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
        $vote->liked = 1;
        $vote->disliked = 0;
        $vote->save();
    }

    public function dislikePost(int|string $id)
    {
        $post = Post::find($id);
        $vote = $post->vote();
        $vote->liked = 0;
        $vote->disliked = 1;
        $vote->save();
    }
}
