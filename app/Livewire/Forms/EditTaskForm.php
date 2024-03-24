<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Task;
use Livewire\Attributes\Validate;

class EditTaskForm extends Form
{
    public Task $task;

    #[Validate('required|max:255')]
    public $title = '';

    #[Validate('nullable|max:1000')]
    public $description = '';

    #[Validate('nullable|date|after_or_equal:today')]
    public $dueDate = null;

    #[Validate('required')]
    public $priority = null;

    public function setTask(Task $task)
    {
        $this->task = $task;

        $this->title = $task->title;
        $this->priority = $task->priority;
        $this->description = $task->description;
        $this->dueDate = optional($task->due_date)->format('Y-m-d');
    }

    public function update()
    {
        $this->validate();

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->dueDate,
            'priority' => $this->priority,
        ]);
    }
}
