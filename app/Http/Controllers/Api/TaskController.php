<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /api/projects/{project}/tasks
    public function index(Project $project): AnonymousResourceCollection
    {
        $tasks = $project->tasks()
            ->orderBy('completed')              // incomplete float to top
            ->orderByRaw("CASE priority WHEN 'high' THEN 0 WHEN 'medium' THEN 1 ELSE 2 END")
            ->latest()
            ->get();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    // POST /api/projects/{project}/tasks
    public function store(Request $request, Project $project): TaskResource
    {
        $task = $project->tasks()->create($request->validated());

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // PUT /api/projects/{project}/tasks/{task}
    public function update(Request $request, Project $project, Task $task): TaskResource
    {
        $task->update($request->validated());

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    // DELETE /api/projects/{project}/tasks/{task}
    public function destroy(Project $project, Task $task): Response
    {
        $task->delete();

        return response()->noContent();
    }
}
