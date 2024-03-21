<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Tasks') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4">
            <ul role="list" class="divide-y divide-gray-800 dark:divide-gray-700">
                @foreach($tasks as $task)
                    <li wire:key="{{ $task->id }}" class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-white">{{ $task->title }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</div>
