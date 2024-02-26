<div class="p-6">
    {{-- Top sections of the page (back button) --}}
    <div>
        {{-- Back button --}}
        <button wire:navigate href="{{ route('posts') }}" class="btn-info">
            <div class="flex items-center gap-1">
                <x-simpleline-arrow-left-circle class="h-6 w-6 fill-current" /> Back
            </div>
        </button>
    </div>

    {{-- Middle section of the page (form in wich the user can edit the post details) --}}
    <div>
        <form wire:submit.prevent="createPost">
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
                        <textarea wire:model.live="content" id="content" name="content" rows="3"
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
                <select id="status" name="status" wire:model.live="status"
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
