<div>
    {{-- Chat icon --}}
    <div class="fixed bottom-4 right-4">
        <button class="btn-info" wire:click='showChat'>
            <div class="flex items-center gap-1">
                <x-simpleline-bubbles class="h-6 w-6 fill-current" />
            </div>
        </button>
    </div>

    @if ($chatShown)

        {{-- Chat window --}}
        <div class="fixed bottom-4 right-4 border-2 rounded-lg border-gray-500 dark:border-gray-200">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg w-96">
                <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded-t-lg">
                    <h1 class="text-lg font-bold dark:text-white">Chat</h1>
                    <button class="btn-info" wire:click='hideChat'>
                        <x-simpleline-close class="h-6 w-6 fill-current" />
                    </button>
                </div>
                {{-- A list of friends --}}
                <div class="p-2 max-h-52 overflow-y-scroll scroll">
                    <h1 class="text-lg font-bold dark:text-white">Friends</h1>
                    @if (!$friends->isEmpty())
                        @foreach ($friends as $friend)
                            <div
                                class="flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded-lg mt-2">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $friend->profile_photo_url }}" alt="avatar"
                                        class="w-10 h-10 rounded-full">
                                    <h1 class="text-sm font-bold">{{ $friend->name }}</h1>
                                </div>
                                <div class="flex gap-0">
                                    <button class="btn-sm-info" wire:click="startChat({{ $friend->id }})">
                                        <x-simpleline-bubbles class="h-5 w-5 fill-current" />
                                    </button>
                                    <button class="btn-sm-danger" wire:click="removeFriend({{ $friend->id }})">
                                        <x-simpleline-trash class="h-5 w-5 fill-current" />
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400">No friends found</p>
                    @endif
                </div>
                <hr class="my-2">
                {{-- Accounts you can add as friends --}}
                <div class="p-2 max-h-52 overflow-y-scroll scroll">
                    <div class="flex items-center gap-2">
                        <input type="text" class="w-full rounded-lg border-gray-200 dark:border-gray-600"
                            placeholder="Search for people..." wire:model.live="search" wire:input='searchUser'>
                        <button class="btn-info" wire:click="searchUser">
                            <x-simpleline-magnifier class="h-6 w-6 fill-current" />
                        </button>
                    </div>
                    <div class="mt-2">
                        @if (!$foundUsers->isEmpty())
                            @foreach ($foundUsers as $user)
                                <div
                                    class="flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded-lg mt-2">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $user->profile_photo_url }}" alt="avatar"
                                            class="w-10 h-10 rounded-full">
                                        <h1 class="text-sm font-bold">{{ $user->name }}</h1>
                                    </div>
                                    <button class="btn-info" wire:click="addFriend({{ $user->id }})">
                                        <x-simpleline-plus class="h-6 w-6 fill-current" />
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400">No users found</p>
                        @endif

                    </div>
                </div>
                {{-- <div class="p-2">
                    <div class="flex items-center gap-2">
                        <input type="text" class="w-full rounded-lg border-gray-200 dark:border-gray-600"
                            placeholder="Type a message..." wire:model.live="message" wire:keydown.enter="sendMessage">
                        <button class="btn-info" wire:click="sendMessage">
                            <x-simpleline-paper-plane class="h-6 w-6 fill-current" />
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
    @endif

</div>
