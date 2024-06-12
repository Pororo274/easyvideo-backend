<?php

namespace App\Contracts\Repositories;

use App\Dto\Projects\CreateProjectDto;
use App\Dto\Projects\UpdateProjectPreviewDto;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryContract
{
    public function store(CreateProjectDto $dto): Project;
    public function getAllByUserId(int $userId): Collection;
    public function findById(int $projectId): Project;
    public function updatePreview(UpdateProjectPreviewDto $dto): Project;
    public function deleteById(int $projectId): Project;
}
