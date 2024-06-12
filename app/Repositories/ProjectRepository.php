<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProjectRepositoryContract;
use App\Dto\Projects\CreateProjectDto;
use App\Dto\Projects\UpdateProjectPreviewDto;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

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

    public function getAllByUserId(int $userId): Collection
    {
        return Project::query()->where('user_id', $userId)->orderBy('updated_at', 'desc')->get();
    }

    public function findById(int $projectId): Project
    {
        return Project::query()->find($projectId);
    }

    public function updatePreview(UpdateProjectPreviewDto $dto): Project
    {
        Project::query()->where('id', $dto->projectId)->update([
            'preview' => $dto->preview
        ]);

        return $this->findById($dto->projectId);
    }

    public function deleteById(int $projectId): Project
    {
        $project = $this->findById($projectId);
        $project->delete();
        return $project;
    }
}
