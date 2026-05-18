<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = ['project_id', 'title', 'completed', 'priority'];

    protected $casts = [
        // Ensures 'completed' is always true/false in PHP and 1/0 in the DB
        // Without this, the API would return "0" and "1" as strings — Vue would
        // misread both as truthy since they're non-empty strings

        'completed' => 'boolean',
    ];

    public function projects(): BelongsTo {
        return $this->belongsTo(Project::class);
    }
}
