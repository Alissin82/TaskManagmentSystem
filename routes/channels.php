<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tasks-channel', function () {
    return true;
});
