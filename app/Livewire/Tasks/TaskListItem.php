<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;

class TaskListItem extends Component
{
    public Task $task;

    public function mount(Task $task)
    {
        $this->task = $task;
    }

    public function render()
    {
        return view('livewire.tasks.task-list-item');
    }

    public function toggleComplete()
    {
        $this->authorize('update', $this->task);

        $this->task->toggleComplete();

        $this->dispatch('updated');
    }

    public function togglePinned()
    {
        $this->authorize('update', $this->task);

        $this->task->togglePinned();

        $this->dispatch('updated');
    }
}
