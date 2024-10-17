<?php

namespace App\Enums;

use App\Traits\EnumToArrayTrait;

enum TaskStatus: string
{
    use EnumToArrayTrait;
    case pending = 'pending';
    case suspended = 'suspended';
    case completed = 'completed';
}
