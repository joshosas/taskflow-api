<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

// Health check — no auth needed
Route::get('/ping', fn() => response()->json(['message' => 'pong']));

// Auth routes — no middleware
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout']);

// Protected routes — Sanctum checks the session cookie on every request
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'user']);

    Route::apiResource('projects', ProjectController::class);

    Route::apiResource('projects.tasks', TaskController::class)->only([
        'index', 'store', 'update', 'destroy',
    ]);

});