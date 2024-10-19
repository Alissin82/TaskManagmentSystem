<?php

namespace App\Dto;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Traits\DtoToArrayTrait;

class TaskDto
{
    use DtoToArrayTrait;

    public string $title;
    public ?string $description;
    public ?int $priority;
    public ?string $status;
    public ?string $due_date;

    /**
     * @param mixed $data{
     *     title: string,
     *     description: string,
     *     int: string,
     *     status: string,
     *     due_date: string,
     * }
     */
    public function __construct(mixed $data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'] ?? null;
        $this->priority = $data['priority'] ?? TaskPriority::normal->value;
        $this->status = $data['status'] ?? TaskStatus::pending->value;
        $this->due_date = $data['due_date'] ?? null;
    }
}
