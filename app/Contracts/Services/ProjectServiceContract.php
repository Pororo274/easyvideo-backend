<?php

namespace App\Contracts\Services;

use App\Dto\Projects\CreateProjectDto;
use App\Dto\Projects\ProjectDto;
use App\Models\Project;
use Illuminate\Support\Collection;

interface ProjectServiceContract
{
    public function store(CreateProjectDto $dto): Project;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getAllByUserId(int $userId): Collection;

    /**
     * @param int $projectId
     * @return ProjectDto
     */
    public function findById(int $projectId): ProjectDto;
}
