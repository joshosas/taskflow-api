<?php

// Api/ProjectController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /api/projects
    public function index(Request $request): AnonymousResourceCollection
    {
        $projects = $request->user()
            ->projects()
            ->withCount([
                'tasks',
                'tasks as completed_tasks_count' => fn($q) => $q->where('completed', true),
            ])
            ->latest()
            ->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
     // POST /api/projects
    public function store(StoreProjectRequest $request): ProjectResource
    {
        $project = $request->user()
            ->projects()
            ->create($request->validated());

            return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     */
    // GET /api/projects/{project}
    public function show(Project $project): ProjectResource
    {
        $project->loadCount([
            'tasks',
            'tasks as completed_tasks_count' => fn($q) => $q->where('completed', true),
        ]);

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    // PUT /api/projects/{project}
    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        $project->update($request->validated());

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    // DELETE /api/projects/{project}
    public function destroy(Project $project): Response
    {
        $project->delete();
        
        return response()->noContent(); // 204 - success with no body
    }
}
