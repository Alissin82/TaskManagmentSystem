<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\CustomRequest;
use App\Models\Task;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTaskRequest extends CustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route()->parameter('task');

        if (!Task::find($id)) {
            throw new ModelNotFoundException('Task not found.');
        }

        return [];
    }
}
