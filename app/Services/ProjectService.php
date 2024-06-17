<?php

namespace App\Services;

use App\Contracts\Repositories\MediaRepositoryContract;
use App\Contracts\Repositories\ProjectRepositoryContract;
use App\Contracts\Services\ProjectServiceContract;
use App\Dto\Projects\CreateProjectDto;
use App\Dto\Projects\ProjectDto;
use App\FFMpeg\Dto\ExporterDto;
use App\Models\Media;
use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        protected ProjectRepositoryContract $projectRepo,
        protected MediaRepositoryContract $mediaRepo
    ) {
    }

    public function store(CreateProjectDto $dto): Project
    {
        return $this->projectRepo->store($dto);
    }

    public function getAllByUserId(int $userId): Collection
    {
        return $this->projectRepo->getAllByUserId($userId)->map(function (Project $project) {
            return $project->toDto();
        });
    }

    public function findById(int $projectId): ProjectDto
    {
        return $this->projectRepo->findById($projectId)->toDto();
    }

    public function deleteById(int $projectId): ProjectDto
    {
        $medias = $this->mediaRepo->findAllByProjectId($projectId);

        $medias->each(function (Media $media) {
            Storage::delete($media->path);
        });
        $this->mediaRepo->deleteAllByProjectId($projectId);

        return $this->projectRepo->deleteById($projectId)->toDto();
    }
}
