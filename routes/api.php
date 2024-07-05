<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('tasks/search', [TaskController::class, 'search']);
Route::apiResource('/tasks', TaskController::class);
