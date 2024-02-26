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
        {

        {{-- Chat window --}}
        <div class="fixed bottom-4 right-4">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg w-96">
                <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded-t-lg">
                    <h1 class="text-lg font-bold">Chat</h1>
                    <button class="btn-info" wire:click='hideChat'>
                        <x-simpleline-close class="h-6 w-6 fill-current" />
                    </button>
                </div>
                <div class="p-2">
                    <div class="flex items-center gap-2">
                        <input type="text" class="w-full rounded-lg border-gray-200 dark:border-gray-600"
                            placeholder="Type a message..." wire:model.live="message" wire:keydown.enter="sendMessage">
                        <button class="btn-info" wire:click="sendMessage">
                            <x-simpleline-paper-plane class="h-6 w-6 fill-current" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
        }
    @endif

</div>
