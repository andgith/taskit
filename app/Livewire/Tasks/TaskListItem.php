<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Livewire\Forms\EditTaskForm;

class TaskListItem extends Component
{
    public Task $task;

    public $showEditDialog = false;

    public EditTaskForm $form;


    public function mount(Task $task)
    {
        $this->task = $task;

        $this->form->setTask($this->task);
    }

    public function resetForm()
    {
        $this->form->setTask($this->task);
    }

    public function render()
    {
        return view('livewire.tasks.task-list-item');
    }

    public function update()
    {
        $this->authorize('update', $this->task);

        $this->form->update();

        $this->task->refresh();

        $this->reset('showEditDialog');

        $this->dispatch('updated');
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
