<?php

namespace Tests\Feature\Livewire\Tasks;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Tasks\ShowTasks;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function page_renders_correctly()
    {
        $this->actingAs(User::factory()->create())
            ->get('/tasks')
            ->assertSeeLivewire(ShowTasks::class);
    }

    /** @test */
    public function users_must_be_authenticated()
    {
        $this->get('/tasks')->assertRedirect('/login');
    }

    /** @test */
    public function it_has_all_tasks()
    {
        $user = User::factory()->hasTasks(2)->create();

        Livewire::actingAs($user)
            ->test(ShowTasks::class)
            ->assertViewHas('tasks', function ($tasks) {
                return count($tasks) == 2;
            });
    }

    /** @test */
    public function it_displays_all_tasks()
    {
        $user = User::factory()->create();

        $task1 = Task::factory()->for($user)->create();
        $task2 = Task::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(ShowTasks::class)
            ->assertSee($task1->title)
            ->assertSee($task2->title);
    }

    /** @test */
    public function it_only_displays_tasks_for_authenticated_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $tasksForUser1 = Task::factory(2)->for($user1)->create();
        $tasksForUser2 = Task::factory()->for($user2)->create();

        Livewire::actingAs($user1)
            ->test(ShowTasks::class)
            ->assertViewHas('tasks', function ($tasks) {
                return count($tasks) == 2;
            });

        Livewire::actingAs($user2)
            ->test(ShowTasks::class)
            ->assertViewHas('tasks', function ($tasks) {
                return count($tasks) == 1;
            });
    }

    /** @test */
    public function it_can_add_a_new_task_for_user()
    {
        $user = User::factory()->create();

        $this->assertEquals(0, $user->tasks()->count());

        Livewire::actingAs($user)
            ->test(ShowTasks::class)
            ->set('newTaskTitle', 'Brand new task!')
            ->call('addTask');

        $this->assertEquals(1, $user->tasks()->count());
    }

    /** @test */
    public function the_task_title_is_required()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(ShowTasks::class)
            ->set('newTaskTitle', '')
            ->call('addTask')
            ->assertHasErrors(['newTaskTitle' => 'required']);
    }

    /** @test */
    public function it_resets_task_title_after_adding()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(ShowTasks::class)
            ->set('newTaskTitle', 'Brand new task!')
            ->call('addTask')
            ->assertSet('title', '');
    }
}
