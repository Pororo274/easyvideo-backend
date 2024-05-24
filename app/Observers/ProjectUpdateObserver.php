<?php

namespace App\Observers;

use App\Contracts\Observers\ProjectUpdatedContract;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ProjectUpdateObserver
{
    public function updated(ProjectUpdatedContract $projectUpdated): void
    {
        Project::query()->where('id', $projectUpdated->getProjectId())->update([
            'updated_at' => Carbon::now()
        ]);
    }

    public function created(ProjectUpdatedContract $projectUpdated): void
    {
        Project::query()->where('id', $projectUpdated->getProjectId())->update([
            'updated_at' => Carbon::now()
        ]);
    }
}
