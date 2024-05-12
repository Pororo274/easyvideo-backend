<?php

namespace App\Services;

use App\Contracts\Repositories\ProjectRepositoryContract;
use App\Contracts\Services\ProjectServiceContract;
use App\Dto\Projects\CreateProjectDto;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        protected ProjectRepositoryContract $projectRepo,
    ) {
    }

    public function store(CreateProjectDto $dto): Project
    {
        $project = $this->projectRepo->store($dto);

        return $project;
    }

    public function getAllByUserId(int $userId): Collection
    {
        return $this->projectRepo->getAllByUserId($userId);
    }

    public function findById(int $projectId): Project
    {
        return $this->projectRepo->findById($projectId);
    }
}
