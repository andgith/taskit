<?php

namespace Tests\Feature\Livewire\Tasks;

use App\Livewire\Tasks\TaskListItem;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TaskListItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(TaskListItem::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_toggle_complete_status()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create([
            'completed_at' => null
        ]);

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->call('toggleComplete');

        $this->assertNotNull($task->fresh()->completed_at);

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->call('toggleComplete');

        $this->assertNull($task->fresh()->completed_at);
    }

    /** @test */
    public function a_user_can_only_toggle_status_for_own_tasks()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create([
            'completed_at' => null
        ]);

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->call('toggleComplete')
            ->assertForbidden();
    }
}
