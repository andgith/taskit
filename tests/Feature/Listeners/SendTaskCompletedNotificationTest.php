<?php

namespace Tests\Feature\Listeners;

use App\Events\TaskCompleted;
use App\Listeners\SendTaskCompletedNotification;
use App\Models\Task;
use App\Notifications\TaskCompletedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendTaskCompletedNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function listener_is_attached_to_event()
    {
        Event::fake();
        Event::assertListening(
            TaskCompleted::class,
            SendTaskCompletedNotification::class
        );
    }

    /** @test */
    public function it_sends_notification_if_task_was_pinned()
    {
        Notification::fake();

        $task = Task::factory()->create([
            'pinned' => true
        ]);

        $event = new TaskCompleted($task);

        $listener = new SendTaskCompletedNotification();

        $listener->handle($event);

        Notification::assertSentTo($task->user, TaskCompletedNotification::class);
    }

    /** @test */
    public function it_does_not_send_notification_if_task_not_pinned()
    {
        Notification::fake();

        $task = Task::factory()->create([
            'pinned' => false
        ]);

        $event = new TaskCompleted($task);

        $listener = new SendTaskCompletedNotification();

        $listener->handle($event);

        Notification::assertNothingSent();
    }

    /** @test */
    public function its_is_triggered_when_task_completed_status_toggled()
    {
        Event::fake();

        $task = Task::factory()->create();

        $task->toggleComplete();

        Event::assertDispatched(TaskCompleted::class, function ($e) use ($task) {
            return $e->task->is($task);
        });
    }
}
