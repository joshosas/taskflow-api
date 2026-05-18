<?php

// routes/api.php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public health check — useful for testing the API is alive
Route::get('/ping', fn() => response()->json(['message' => 'pong']));

Route::middleware('auth:sanctum')->group(function () {

    // Authenticated user
    Route::get('/user', fn(Request $request) => $request->user());

    // /api/projects — index, store, show, update, destroy
    Route::apiResource('projects', ProjectController::class);

    // /api/projects/{project}/tasks — index, store, update, destroy
    // only: excludes 'show' since Vue doesn't need a single-task endpoint
    Route::apiResource('projects.tasks', TaskController::class)->only([
        'index', 'store', 'update', 'destroy',
    ]);

});