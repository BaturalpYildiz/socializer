<div class="p-6">
    {{-- Top sections of the page (title and back button) --}}
    <div class="flex justify-between items-center">
        <div class="my-2">
            <h1 class="text-2xl font-bold dark:text-gray-200">{{ $title }}</h1>
            {{-- small text underneath h1 --}}
            <p class="text-gray-500 dark:text-gray-400 text-sm leading-3">
                Created: {{ $currentPost->created_at }}<br>
                Last updated: {{ $currentPost->updated_at }}
            </p>
        </div>
        <div>
            {{-- Delete button --}}
            <button wire:click="deletePost" class="btn-danger">
                <div class="flex items center gap-1">
                    <x-simpleline-trash class="h-6 w-6 fill-current" /> Delete Post
                </div>
            </button>
            {{-- Back button --}}
            <button wire:navigate href="{{ route('posts') }}" class="btn-info">
                <div class="flex items-center gap-1">
                    <x-simpleline-arrow-left-circle class="h-6 w-6 fill-current" /> Back
                </div>
            </button>
        </div>

    </div>
    <hr>
    {{-- Middle section of the page (form in wich the user can edit the post details) --}}
    <div>
        <form wire:submit.prevent="updatePost">
            <div class="grid grid-cols-1 gap-6 mt-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Title
                    </label>
                    <div class="mt-1">
                        <input wire:model.live="title" type="text" name="title" id="title"
                            class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    </div>
                    @error('title')
                        <span class="text-red-500 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Content
                    </label>
                    <div class="mt-1">
                        <textarea wire:model="content" id="content" name="content" rows="3"
                            class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"></textarea>
                    </div>
                    @error('content')
                        <span class="text-red-500 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- Options selection for the post --}}
            <div class="mt-6">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Status
                </label>
                <select wire:model="status" id="status" name="status"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">

                    @foreach ($all_status as $status)
                        <option value="{{ $status->id }}">{{ ucfirst($status->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>
        </form>
    </div>

</div>
