<?php

namespace App\Livewire\Pages;

use App\Dto\TaskDto;
use App\Enums\TaskPriority;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Services\Task\TaskService;
use Exception;
use Illuminate\View\View;
use Livewire\Component;
use App\Models\Task;
use Morilog\Jalali\Jalalian;
use Validator;

class Tasks extends Component
{
    public $task_id;
    public $title;
    public $description;
    public $due_date;
    public $priority;

    public $errors = [];
    public $updateMode = false;

    private $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    private function jalaliToGregorian($datetime): string
    {
        return Jalalian::fromFormat('Y/m/d H:i:s', $datetime)->toCarbon()->format('Y-m-d H:i:s');
    }

    public function clearInputs(): void
    {
        $this->errors = [];
        $this->updateMode = false;
        $this->task_id = null;
        $this->title = null;
        $this->description = null;
        $this->due_date = null;
        $this->priority = TaskPriority::normal->value;
    }

    public function submitForm(): void
    {
        $this->errors = [];
        if ($this->updateMode){
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store(): void
    {
        $this->errors = [];
        try {
            $taskArray = [
                'title' => $this->title,
                'description' => $this->description,
                'due_date' => $this->due_date != null ? $this->jalaliToGregorian($this->due_date) : null,
                'priority' => $this->priority,
            ];

            $errors = Validator::make($taskArray, (new StoreTaskRequest())->rules())->errors()->all();
            if ( count($errors) > 0 ){
                $this->errors = $errors;
            } else {
                $this->taskService->store( new TaskDto($taskArray));
                session()->flash('message', 'وظیفه با موفقیت ساخته شد');
                $this->clearInputs();
            }
        } catch (Exception $exception){
            $this->errors = [
                'خطایی در ثبت وظیفه رخ داد',
                $exception->getMessage()
            ];
        }
    }

    public function edit($id): void
    {
        $this->errors = [];
        $this->updateMode = false;
        try {
            if (Task::find($id)){
                $task = $this->taskService->get($id);

                $this->title = $task->title;
                $this->description = $task->description;
                $this->due_date = $task->due_date;
                $this->priority = $task->priority;

                $this->task_id = $id;

                $this->updateMode = true;
            } else {
                $this->errors = ['وظیفه یافت نشد'];
            }
        } catch (Exception){
            $this->errors = [
                'خطایی در پیدا کردن وظیفه رخ داد'
            ];
        }
    }

    public function update(): void
    {
        $this->errors = [];
        try {
            $taskArray = [
                'id' => $this->task_id,
                'title' => $this->title,
                'description' => $this->description,
                'due_date' => $this->due_date != null ? $this->jalaliToGregorian($this->due_date) : null,
                'priority' => $this->priority,
            ];

            $errors = Validator::make($taskArray, (new UpdateTaskRequest())->rules())->errors()->all();
            if ( count($errors) > 0 ){
                $this->errors = $errors;
            } else {
                $this->taskService->update( $taskArray, $this->task_id );
                session()->flash('message', 'وظیفه با موفقیت ویرایش شد');
                $this->clearInputs();
            }
        } catch (Exception){
            $this->errors = [
                'خطایی در ویرایش وظیفه رخ داد'
            ];
        }
    }

    public function delete($id): void
    {
        $this->errors = [];
        try {
            if (Task::find($id)){
                $this->taskService->delete($id);
                session()->flash('message', 'وظیفه با موفقیت حذف شد');
            } else {
                $this->errors = ['وظیفه یافت نشد'];
            }
        } catch (Exception){
            $this->errors = [
                'خطایی در حذف وظیفه رخ داد'
            ];
        }
    }

    public function render(): view
    {
        return view('livewire.pages.tasks', [
            'priorities' => TaskPriority::values(),
            'tasks' => Task::all()->sortByDesc('created_at')
        ]);
    }
}
