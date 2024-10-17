<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Dto\TaskDto;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Task_C;

class TaskService
{
    public function index(): Collection|array|_IH_Task_C
    {
        return Task::all();
    }

    public function get(int $id): array|Task|_IH_Task_C|null
    {
        return Task::findOrFail($id);
    }

    public function store(TaskDto $task){
        return Task::create($task->toArray());
    }

    public function update(TaskDto $task, int $id): int
    {
        return Task::whereId($id)->update($task->toArray());
    }

    public function delete(int $id){
        return Task::whereId($id)->delete();
    }
}
