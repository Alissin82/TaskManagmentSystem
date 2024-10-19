<?php

namespace App\Enums;

use App\Traits\EnumToArrayTrait;

enum TaskPriority: int
{
    use EnumToArrayTrait;
    case important = 4;
    case high = 3;
    case normal = 2;
    case low = 1;
}
