<div>
    {{-- Header (post creation | navigation) --}}
    <div class="flex justify-between items-center p-6 sm:px-20">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
        <a wire:navigate href="{{ route('posts.create') }}" class="btn">
            {{ __('Create Post') }}
        </a>
    </div>

    <div class="p-6 sm:px-20 flex gap-6 ">
        <div class="md:flex-grow">
            {{-- Pagination (TODO: make it a custom navigation with the searchbar integrated for the best experience) --}}
            {{-- TODO: Pagination has a fault. When the post is viewed and the modal is closed the href tags to the different pages changes to "livewire/update" --}}
            {{ $posts->links('pagination::tailwind') }}

        </div>
        <div class="md:flex-shrink">
            <div class="relative mx-auto text-gray-600">
                {{-- search bar --}}
                <input type="text" wire:model.live="query"
                    class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none dark:text-white dark:bg-gray-600 dark:border-2 dark:border-gray-300">
                <div class="absolute right-0 top-0 mt-3 mr-4">
                    {{-- search icon --}}
                    <x-simpleline-magnifier class="text-gray-600 dark:text-gray-50 h-4 w-4 fill-current" />
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="p-6 sm:px-20">
        {{-- Body (posts) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($posts as $post)
                {{-- Post --}}
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg min-h-48 w-2/5 md:w-4/5 justify-self-center flex flex-col">
                    <div class="relative w-auto h-auto">
                        <div class="absolute top-0 right-0 p-2 grid grid-cols-2">
                            <button wire:click="likePost('{{ $post->id }}')">
                                @if ($post->vote()->liked)
                                    <x-bxs-like class="h-8 w-8 text-green-400 dark:text-green-800" />
                                @else
                                    <x-bx-like class="h-8 w-8 text-green-400 dark:text-green-800" />
                                @endif
                            </button>
                            <button wire:click="dislikePost('{{ $post->id }}')">
                                @if ($post->vote()->disliked)
                                    <x-bxs-dislike class="h-8 w-8 text-red-400 dark:text-red-800" />
                                @else
                                    <x-bx-dislike class="h-8 w-8 text-red-400 dark:text-red-800" />
                                @endif
                            </button>
                        </div>

                    </div>
                    <div class="p-6 flex-grow">
                        <div class="flex flex-row">
                            {{-- User photo --}}
                            <img class="h-8 w-8 rounded-full object-cover " src="{{ $post->user->profile_photo_url }}"
                                alt="{{ $post->user->name }}" />
                            {{-- User name and when it was posted --}}
                            <p class="ms-2 text-gray-500 dark:text-gray-400 grid whitespace-nowrap leading-tight">
                                {{ ucfirst($post->user->name) }}
                                <span class="text-gray-400 dark:text-gray-600 ">
                                    {{ empty($post->created_at)
                                        ? 'Post date unknow'
                                        : ($post->created_at->diffInWeeks() > 1
                                            ? $post->created_at->format('d/m/Y')
                                            : $post->created_at->diffForHumans()) }}
                                </span>
                            </p>
                        </div>
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-pretty">
                            {{ $post->title }}
                        </h2>

                        <p class="text-gray-500 dark:text-gray-400 text-pretty line-clamp-2">
                            {{ $post->content }}
                        </p>

                    </div>
                    {{-- footer --}}
                    <div class="bg-gray-600 flex">
                        <div class="flex-grow">
                            {{-- show the status of the post --}}
                            <p class="text-white text-pretty p-2">
                                Status:
                                {{-- id 1 = concept, 2 = draft, 3 = published --}}
                                @if ($post->status->id == 2)
                                    <span class="text-yellow-500 dark:text-yellow-400">
                                        {{ ucfirst($post->status->name) }}!
                                    </span>
                                @elseif ($post->status->id == 3)
                                    <span class="text-green dark:text-green-400">
                                        {{ ucfirst($post->status->name) }}
                                    </span>
                                @endif
                            </p>

                        </div>
                        <div class="gap-2 ">
                            @if (Auth::user()->id === $post->user_id)
                                {{-- TODO: Add editing functionality --}}
                                <button wire:click="editPost('{{ $post->id }}')" class="btn-info">
                                    {{ __('Edit Post') }}
                                </button>
                            @endif
                            <button wire:click="showPost('{{ $post->id }}')" class="btn">
                                {{ __('View Post') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <hr>
    {{-- Footer (navigation) --}}
    <div class="p-6 sm:px-20">
        {{ $posts->links('pagination::tailwind') }}
    </div>

    <x-dialog-modal wire:model.live="displayingPost">
        <x-slot name="title">
            {{-- Title of the post and the user name and profile --}}
            <div class="flex flex-row">
                <img class="h-8 w-8 rounded-full object-cover " src="{{ $postDetails->user->profile_photo_url ?? '' }}"
                    alt="{{ $postDetails->user->name ?? '' }}" />
                <p class="ms-2 text-gray-500 dark:text-gray-400 grid whitespace-nowrap leading-tight">
                    {{ ucfirst($postDetails->user->name ?? '') }}
                    <span class="text-gray-400 dark:text-gray-600 text-sm">
                        last updated:
                        {{ empty($postDetails->updated_at ?? '')
                            ? (empty($postDetails->created_at ?? '')
                                ? 'Last update date unknow'
                                : $postDetails->created_at->format('d/m/Y H:i'))
                            : $postDetails->updated_at->format('d/m/Y H:i') }}
                    </span>

                </p>
            </div>
            {{-- Title of the post --}}
            <hr>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-pretty">
                {{ $postDetails->title ?? '' }}
            </h2>


        </x-slot>
        <x-slot name="content">
            {{ __($postDetails->content ?? '') }}
        </x-slot>

        <x-slot name="footer">
            {{-- Status of the post --}}
            <div class="flex-grow">
                <p class="text-white text-pretty p-2">
                    Status:
                    {{-- id 1 = concept, 2 = draft, 3 = published --}}
                    @if (!empty($postDetails->status))

                        @if ($postDetails->status->id == 2)
                            <span class="text-yellow-500 dark:text-yellow-400">
                                {{ ucfirst($postDetails->status->name) }}!
                            </span>
                        @elseif ($postDetails->status->id == 3)
                            <span class="text-green-400 dark:text-green-400">
                                {{ ucfirst($postDetails->status->name) }}
                            </span>
                        @endif

                    @endif
                </p>
            </div>
            <div class="float-end gap-2">
                <button class="btn-secondary" wire:click="closePost">
                    {{ __('Close') }}
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>


</div>
