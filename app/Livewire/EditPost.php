<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\post_status;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class EditPost extends Component
{
    public string $title = "";
    public string $content = "";
    public int $status = 0;
    public Post|null $currentPost;
    public Collection $all_status;

    public function mount()
    {
        $this->setPostDetails(request()->route('id'));
        $this->all_status = post_status::all();
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
    private function setPostDetails(int|string $id)
    {
        if (empty($id) || !Post::find($id)) {
            return;
        }

        $this->currentPost = Post::find($id);
        $this->title = $this->currentPost->title;
        $this->content = $this->currentPost->content;
        $this->status = $this->currentPost->status_id;
    }

    public function updatePost()
    {
        $this->currentPost->title = $this->title;
        $this->currentPost->content = $this->content;
        $this->currentPost->status_id = $this->status;
        $this->currentPost->save();
        return redirect()->route('posts')->with('success', 'Post updated successfully');
    }

    public function deletePost()
    {
        $this->currentPost->delete();
        return redirect()->route('posts')->with('success', 'Post deleted successfully');
    }
}
