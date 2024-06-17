<?php

namespace App\Repositories;

use App\Contracts\Repositories\MediaRepositoryContract;
use App\Dto\Media\CreateMediaDto;
use App\Enums\Media\MediaTypeEnum;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;

class MediaRepository implements MediaRepositoryContract
{
    public function store(CreateMediaDto $dto): Media
    {
        return Media::query()->create([
            'path' => $dto->path,
            'project_id' => $dto->projectId,
            'uuid' => $dto->mediaUuid,
            'original_name' => $dto->originalName,
            'type' => $dto->type,
            'is_uploaded' => $dto->isUploaded
        ]);
    }

    public function findByUuid(string $uuid): Media
    {
        return Media::query()->where('uuid', $uuid)->firstOrFail();
    }

    public function updateUploadStatusByUuid(string $uuid, bool $isUploaded): Media
    {
        Media::query()->where('uuid', $uuid)->update([
            'is_uploaded' => $isUploaded
        ]);

        return $this->findByUuid($uuid);
    }

    public function findAllByProjectId(int $projectId): Collection
    {
        return Media::query()->where('project_id', $projectId)->where('type', MediaTypeEnum::ASSET)->get();
    }

    public function findByTypeAndProjectId(int $projectId, MediaTypeEnum $type): Collection
    {
        return Media::query()->where([
            'project_id' => $projectId,
            'type' => $type
        ])->all();
    }

    public function deleteAllByProjectId(int $projectId): void
    {
        Media::query()->where('project_id', $projectId)->delete();
    }
}
