<?php

namespace App\Http\Resources;

use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,

            // Only include task counts when they've been eager-loaded
            // withCount('tasks') → $this->tasks_count
            'tasks_count' => $this->whenNotNull($this->tasks_count),
            'completed_tasks_count' => $this->whenNotNull($this->completed_tasks_count),

            // Only include full task list when tasks relationship is loaded
            // with('tasks') → includes TaskResource collection
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),

            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
