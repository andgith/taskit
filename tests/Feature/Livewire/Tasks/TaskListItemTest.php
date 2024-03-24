<?php

namespace Tests\Feature\Livewire\Tasks;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Livewire\Livewire;
use App\Livewire\Tasks\TaskListItem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskListItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(TaskListItem::class, ['task' => Task::factory()->create()])
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
    public function it_dispatches_updated_event_after_toggling_completed_status()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create([
            'completed_at' => null
        ]);

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->call('toggleComplete')
            ->assertDispatched('updated');
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

    /** @test */
    public function it_can_toggle_pinned_status()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create([
            'pinned' => false
        ]);

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->call('togglePinned');

        $this->assertTrue($task->fresh()->pinned);

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->call('togglePinned');

        $this->assertFalse($task->fresh()->pinned);
    }

    /** @test */
    public function it_dispatches_update_event_after_toggling_pinned()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create([
            'pinned' => false
        ]);

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->call('togglePinned')
            ->assertDispatched('updated');
    }

    /** @test */
    public function a_user_can_only_toggle_pinned_for_own_tasks()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create([
            'pinned' => false
        ]);

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->call('togglePinned')
            ->assertForbidden();
    }

    /** @test */
    public function it_sets_edit_form_fields()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->assertSet('form.title', $task->title)
            ->assertSet('form.description', $task->description)
            ->assertSet('form.dueDate', $task->due_date->format('Y-m-d'))
            ->assertSet('form.priority', $task->priority);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->set('form.title', 'This is a new title')
            ->set('form.description', 'A brand new description')
            ->set('form.dueDate', $date = now()->addDay())
            ->set('form.priority', 1)
            ->call('update')
            ->assertOk();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'This is a new title',
            'description' => 'A brand new description',
            'due_date' => $date,
            'priority' => 1,
        ]);
    }

    /** @test */
    public function it_dispatches_update_event_after_updating_task()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->set('form.title', 'This is a new title')
            ->call('update')
            ->assertDispatched('updated');
    }

    /** @test */
    public function it_can_reset_edit_form()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->set('form.title', 'This is a new title')
            ->call('resetForm')
            ->assertSet('form.title', $task->title);
    }

    /** @test */
    public function due_date_must_be_in_future()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        Livewire::actingAs($user)->test(TaskListItem::class, ['task' => $task])
            ->set('form.title', 'This is a new title')
            ->set('form.description', 'A brand new description')
            ->set('form.dueDate', $date = now()->subDay())
            ->set('form.priority', 1)
            ->call('update')
            ->assertHasErrors('form.dueDate');
    }
}
