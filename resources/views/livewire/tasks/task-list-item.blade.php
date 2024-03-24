<div>
    <li wire:key="{{ $task->id }}" class="flex justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
            <form wire:submit="toggleComplete">
                <button type="submit">
                    <x-task-checkbox :task="$task" />
                </button>
            </form>
            <div class="min-w-0 flex-auto">
                <x-dialog wire:model="showEditDialog">
                    <x-dialog.button>
                        <button type="button" class="text-sm font-semibold leading-6 text-white">
                            {{ $task->title }}
                        </button>
                    </x-dialog.button>

                    <x-dialog.panel>
                        <form wire:submit="update">
                            <div class="px-4 sm:px-6">
                                <h2 class="text-base font-semibold leading-6 text-gray-900" id="slide-over-title">
                                    <x-text-input wire:model="form.title" name="title" class="w-full" />
                                    @error('form.title')
                                        <x-input-error messages="{{ $message }}"></x-input-error>
                                    @enderror
                                </h2>
                            </div>
                            <div class="relative mt-6 flex-1 px-4 sm:px-6 flex flex-col space-y-8">
                                <div>
                                    <x-input-label for="description" value="Description" />
                                    <textarea autofocus wire:model="form.description" name="description" id="description" rows="8"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    @error('form.description')
                                        <x-input-error messages="{{ $message }}"></x-input-error>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="due_date" value="Due Date" />
                                        <x-text-input class="w-full" wire:model="form.dueDate" name="due_date"
                                            id="due_date" type="date" min="{{ now()->format('Y-m-d') }}" />
                                        @error('form.dueDate')
                                            <x-input-error messages="{{ $message }}"></x-input-error>
                                        @enderror
                                    </div>
                                    <div>
                                        <x-input-label for="priority" value="Priority" />

                                        <select wire:model="form.priority"
                                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            name="priority" id="priority">
                                            @foreach (\App\TaskPriority::cases() as $priority)
                                                <option value="{{ $priority->value }}">{{ $priority->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('form.priority')
                                            <x-input-error messages="{{ $message }}"></x-input-error>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <x-dialog.footer>
                                <x-dialog.close>
                                    <button type="button" wire:click="resetForm"
                                        class="text-center rounded-xl bg-slate-300 text-slate-800 px-6 py-2 font-semibold">Cancel</button>
                                </x-dialog.close>

                                <button type="submit"
                                    class="text-center rounded-xl bg-blue-500 text-white px-6 py-2 font-semibold disabled:cursor-not-allowed disabled:opacity-50">Save</button>
                            </x-dialog.footer>
                        </form>
                    </x-dialog.panel>
                </x-dialog>
                @if ($task->due_date)
                    <div class="flex items-center space-x-2 text-gray-400 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd"
                                d="M4 1.75a.75.75 0 0 1 1.5 0V3h5V1.75a.75.75 0 0 1 1.5 0V3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2V1.75ZM4.5 6a1 1 0 0 0-1 1v4.5a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-7Z"
                                clip-rule="evenodd" />
                        </svg>

                        <p class="">{{ $task->due_date->format('M d') }}</p>
                    </div>
                @endif
            </div>
        </div>
        <div>
            <form wire:submit="togglePinned">
                <button type="submit">
                    @if ($task->pinned)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 text-white">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                    @endif
                </button>
            </form>
        </div>
    </li>
</div>
