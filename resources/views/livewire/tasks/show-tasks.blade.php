<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Tasks') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="my-4">
            <form wire:submit="addTask" class="w-full flex items-center space-x-2">
                <x-text-input class="grow" wire:model="newTaskTitle"></x-text-input>
                <x-secondary-button type="submit" class="h-10" disabled
                    x-bind:disabled="$wire.newTaskTitle === ''">Add Task</x-secondary-button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4">
            <ul role="list" class="divide-y divide-gray-800 dark:divide-gray-700">
                @foreach ($tasks->whereNull('completed_at') as $task)
                    <livewire:tasks.task-list-item :$task :key="'incomplete-'.$task->id" @updated="$refresh" />
                @endforeach
            </ul>
        </div>
        <h1 class="text-xl mt-8 mb-2 text-gray-400">Completed Tasks</h1>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4">
            <ul role="list" class="divide-y divide-gray-800 dark:divide-gray-700">
                @foreach ($tasks->whereNotNull('completed_at') as $task)
                    <livewire:tasks.task-list-item :$task :key="'completed-'.$task->id" @updated="$refresh" />
                @endforeach
            </ul>
        </div>
    </div>
</div>
