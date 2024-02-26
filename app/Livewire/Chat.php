<?php

namespace App\Livewire;

use Livewire\Component;

class Chat extends Component
{

    public bool $chatShown = false;

    public function render()
    {
        return view('livewire.chat');
    }

    public function showChat()
    {
        $this->chatShown = true;
    }

    public function hideChat()
    {
        $this->chatShown = false;
    }

    public function sendMessage()
    {
        // Send message
    }
}
