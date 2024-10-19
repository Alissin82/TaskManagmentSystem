<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Events\Task\TaskCreated;
use App\Events\Task\TaskDeleted;
use App\Events\Task\TaskImportantUpdated;
use App\Events\Task\TasksHasChanges;
use App\Events\Task\TaskUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'status',
    ];

    protected $dispatchesEvents = [
        'created' => [TaskCreated::class, TasksHasChanges::class],
        'updated' => [TaskUpdated::class, TasksHasChanges::class],
        'deleted' => [TaskDeleted::class, TasksHasChanges::class],
    ];

    protected static function booted(): void
    {
        static::updated(function ($task){
            if($task->priority == TaskPriority::important->value && $task->wasChanged('priority') ){
                event(new TaskImportantUpdated($task));
            }
        });

        static::created(function ($task){
            if($task->priority == TaskPriority::important->value ){
                event(new TaskImportantUpdated($task));
            }
        });
    }
}
