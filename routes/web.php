<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\Tasks;

Route::get('/', function () {
    return view('welcome');
});

Route::get('tasks', Tasks::class);
