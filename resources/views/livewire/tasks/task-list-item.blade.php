<div>
    <li wire:key="{{ $task->id }}" class="flex justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
            <form wire:submit="toggleComplete">
                <button type="submit">
                    <div class="rounded-full border-white border h-6 w-6 group flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            @class([
                                'w-3 h-3 text-white group-hover:opacity-100 transition ease-in',
                                'opacity-0' => !$task->completed_at,
                            ])>
                            <path fill-rule="evenodd"
                                d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </form>
            <div class="min-w-0 flex-auto">
                <p class="text-sm font-semibold leading-6 text-white">{{ $task->title }}</p>
            </div>
        </div>
    </li>
</div>
