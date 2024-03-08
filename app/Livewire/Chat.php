<?php

namespace App\Livewire;

use App\Models\friends;
use App\Models\User;
use Livewire\Component;

class Chat extends Component
{

    public bool $chatShown = false;
    public string $search = '';
    public $friends;
    public $foundUsers;
    private friends $friendsModel;
    private User $usersModel;

    public function __construct()
    {
        $this->friendsModel = new friends();
        $this->usersModel = new User();
    }

    public function render()
    {
        return view('livewire.chat');
    }

    public function showChat()
    {
        $this->chatShown = true;
        $this->getFriends();
        $this->searchUser();
    }

    public function hideChat()
    {
        $this->chatShown = false;
    }

    public function searchUser()
    {
        // search user
        if (empty($this->search)) {
            $this->foundUsers = $this->usersModel
                ->whereNotIn(
                    'id',
                    array_merge(
                        [auth()->id()],
                        $this->friendsModel->getFriendsOfUser(auth()->id())->pluck('friend1_id')->toArray(),
                        $this->friendsModel->getFriendsOfUser(auth()->id())->pluck('friend2_id')->toArray()
                    )
                )
                ->limit(10)
                ->get();
        } else {
            $this->foundUsers = $this->usersModel
                ->where('name', 'like', '%' . $this->search . '%')
                ->whereNotIn(
                    'id',
                    array_merge(
                        [auth()->id()],
                        $this->friendsModel->getFriendsOfUser(auth()->id())->pluck('friend1_id')->toArray(),
                        $this->friendsModel->getFriendsOfUser(auth()->id())->pluck('friend2_id')->toArray()
                    )
                )
                ->limit(10)
                ->get();
        }
    }

    public function addFriend(int $userId)
    {
        // add friend
        $this->friendsModel->friend1_id = auth()->id();
        $this->friendsModel->friend2_id = $userId;
        $this->friendsModel->save();
        $this->getFriends();
        $this->searchUser();
    }

    private function getFriends()
    {
        // get friends
        $friendRelations = $this->friendsModel->getFriendsOfUser(auth()->id());
        $this->friends = $this->usersModel
            ->whereIn(
                'id',
                array_merge($friendRelations->pluck('friend1_id')->toArray(), $friendRelations->pluck('friend2_id')->toArray())
            )
            ->whereNot('id', auth()->id())
            ->get();
    }
    public function removeFriend(int $friend_id)
    {
        $this->friendsModel->where('friend1_id', auth()->id())->where('friend2_id', $friend_id)->delete();
        $this->friendsModel->where('friend2_id', auth()->id())->where('friend1_id', $friend_id)->delete();
        $this->getFriends();
        $this->searchUser();
    }
    public function sendMessage()
    {
        // Send message
    }
}
