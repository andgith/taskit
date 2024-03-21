<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ShowTasks extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tasks.show-tasks', [
            'tasks' => auth()
                ->user()
                ->tasks()
                ->get(),
        ]);
    }
}
