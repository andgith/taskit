<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class ShowTasks extends Component
{
    #[Validate('required')]
    public $newTaskTitle = '';

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tasks.show-tasks', [
            'tasks' => auth()
                ->user()
                ->tasks()
                ->orderBy('pinned', 'desc')
                ->orderBy('priority')
                ->orderBy('updated_at', 'desc')
                ->get(),
        ]);
    }

    public function addTask()
    {
        $this->validate();

        auth()
            ->user()
            ->tasks()
            ->create([
                'title' => $this->newTaskTitle,
                'description' => ''
            ]);

        $this->reset();
    }
}
