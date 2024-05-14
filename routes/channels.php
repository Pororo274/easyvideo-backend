<?php

use App\Contracts\Services\ProjectServiceContract;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('projects.{projectId}', function (User $user, int $projectId) {
    $project = Project::query()->findOrFail($projectId);
    return $user->id === $project->user_id;
});
