<?php

namespace Tests\Feature;

use App\Events\Task\TaskUpdated;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TaskEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_broadcasts_task_updated_event(): void
    {
        Event::fake();

        $task = Task::create([
            'title' => 'Test Task',
            'description' => 'Test Description',
            'due_date' => now()->addDays(7),
            'priority' => 4,
            'status' => 'pending',
        ]);

        $task->update(['status' => 'completed']);

        Event::assertDispatched(TaskUpdated::class, function ($event) use ($task) {
            return $event->task->id === $task->id;
        });
    }
}
