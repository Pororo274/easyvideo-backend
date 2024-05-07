<?php

namespace App\Services;

use App\Contracts\Repositories\ProjectRepositoryContract;
use App\Contracts\Services\ProjectServiceContract;
use App\Dto\Projects\CreateProjectDto;
use App\Models\Project;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        protected ProjectRepositoryContract $projectRepo
    ) {
    }

    public function store(CreateProjectDto $dto): Project
    {
        $project = $this->projectRepo->store($dto);

        return $project;
    }
}
