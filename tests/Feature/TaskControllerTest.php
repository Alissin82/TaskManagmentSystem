<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    public function testIndex(){
        Task::factory(20)->create();

        $tasks = $this->get('/api/tasks');

        $tasks->assertStatus(200);
    }

    public function testGet(){
        $task = Task::factory()->create();

        $response = $this->get('/api/tasks/'.$task->id);

        $response->assertStatus(200);
    }

    public function testStore(){
        $datetimeResponse = $this->post('/api/tasks', [
            'title' => 'my task',
            'description' => 'my description',
            'due_date' => '2020-12-31 23:59:59',
        ]);
        $datetimeResponse->assertCreated();

        $dateResponse = $this->post('/api/tasks', [
            'title' => 'my task',
            'description' => 'my description',
            'due_date' => '2020-12-31',
        ]);
        $dateResponse->assertCreated();

        $nullDateResponse = $this->post('/api/tasks', [
            'title' => 'my task',
            'description' => 'my description',
        ]);
        $nullDateResponse->assertCreated();
    }

    public function testUpdate(){
        $task = Task::factory()->create();

        $response = $this->put('/api/tasks/'.$task->id, [
            'title' => 'my task',
            'description' => 'my description',
            'due_date' => '2020-12-31 23:59:59',
        ]);
        $response->assertStatus(200);
    }

    public function testDelete(){
        $task = Task::factory()->create();
        $response = $this->delete('/api/tasks/'.$task->id);
        $response->assertStatus(200);
    }

    public function testStoreFailedValidation(){
        $response = $this->post('/api/tasks', [
            'due_date' => 'some bs text', // (instead of datetime value)
            'status' => 'some bs text', // (instead of status enum value)
            'priority' => 'high', // (instead of int value)
        ]);
        $response->assertStatus(422);
    }

    public function testUpdateFailedValidation(){
        $task = Task::factory()->create();

        $response = $this->put('/api/tasks/'.$task->id, [
            'title' => '',
            'description' => '',
            'due_date' => 'some bs text', // (instead of datetime value)
            'status' => 'some bs text', // (instead of status enum value)
            'priority' => 'low', // (instead of int value)
        ]);
        $response->assertStatus(422);
    }

    public function testDeleteFailedValidation(){
        // sending non existing id
        $response = $this->delete('/api/tasks/9999');
        $response->assertStatus(404);
    }
}
