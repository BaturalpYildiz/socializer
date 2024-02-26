<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\post_status;
use Livewire\Component;

class CreatePost extends Component
{
    public $all_status;

    public string $title = "";
    public string $content = "";
    public int $status = 1;

    public function render()
    {
        return view('livewire.create-post');
    }

    public function mount()
    {
        $this->all_status = post_status::all();
        $this->status = $this->all_status->first()->id;
    }

    public function createPost()
    {
        $this->validate(
            [
                'title' => 'required',
                'content' => 'required',
                'status' => 'required',
            ]
        );
        $post = new Post();
        $post->title = $this->title;
        $post->content = $this->content;
        $post->status_id = $this->status;
        $post->user_id = auth()->user()->id;
        $post->save();
        return redirect()->route('posts')->with('success', 'Post created successfully');
    }
}
