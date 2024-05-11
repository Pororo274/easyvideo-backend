<?php

namespace App\Repositories;

use App\Contracts\Repositories\MediaRepositoryContract;
use App\Dto\Media\CreateMediaDto;
use App\Models\Media;

class MediaRepository implements MediaRepositoryContract
{
    public function store(CreateMediaDto $dto): Media
    {
        return Media::query()->create([
            'path' => $dto->path,
            'project_id' => $dto->projectId
        ]);
    }

    public function findById(int $mediaId): Media
    {
        return Media::query()->findById($mediaId);
    }

    public function updateUploadStatusById(int $mediaId, bool $isUploaded): Media
    {
        Media::query()->where('id', $mediaId)->update([
            'is_uploaded' => $isUploaded
        ]);

        return $this->findById($mediaId);
    }
}
