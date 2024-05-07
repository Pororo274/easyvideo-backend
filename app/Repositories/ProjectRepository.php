<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProjectRepositoryContract;
use App\Dto\Projects\CreateProjectDto;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryContract
{
    public function store(CreateProjectDto $dto): Project
    {
        return Project::query()->create([
            'name' => $dto->name,
            'width' => $dto->width,
            'height' => $dto->height,
            'fps' => $dto->fps,
            'user_id' => $dto->userId
        ]);
    }
}
