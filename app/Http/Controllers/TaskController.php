<?php

namespace App\Http\Controllers;

use App\Dto\TaskDto;
use App\Http\Requests\Task\DeleteTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Task\TaskService;
use App\Traits\ApiResponseTrait;
use Exception;
use Log;

class TaskController extends Controller
{

    use ApiResponseTrait;

    public function __construct(private readonly TaskService $taskService){}

    public function index()
    {
        return $this->apiResponse('indexed tasks', TaskResource::collection($this->taskService->index()) );
    }

    /**
     * @throws Exception
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $task = $this->taskService->store(new TaskDto($request->validated()));
            return $this->successResponse('task created', $task, 201);
        } catch (Exception $e){
            Log::error('Error creating task: ' . $e->getMessage());
            throw new Exception(
                'مشکلی در ثبت وظیفه رخ داد'
            );
        }
    }

    public function show(int $id)
    {
        return $this->apiResponse('task fetched', $this->taskService->get($id));
    }

    /**
     * @throws Exception
     */
    public function update(UpdateTaskRequest $request, int $id)
    {
        try {
            $updateResult = $this->taskService->update(new TaskDto($request->validated()), $id);
            return $this->successResponse('task updated', $updateResult);
        } catch (Exception $e){
            Log::error('Error updating task: ' . $e->getMessage());
            throw new Exception(
                'مشکلی در ویرایش وظیفه رخ داد'
            );
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(DeleteTaskRequest $request, int $id)
    {
        try {
            $request->validated();
            $this->taskService->delete($id);
            return $this->successResponse('task deleted');
        } catch (Exception $e){
            Log::error('Error deleting task: ' . $e->getMessage());
            throw new Exception(
                'مشکلی در حذف وظیفه رخ داد'
            );
        }
    }
}
