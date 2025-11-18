<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->get('/tasks', [TaskController::class, 'apiTasks']);
Route::post('/login', [AuthController::class, 'login']);