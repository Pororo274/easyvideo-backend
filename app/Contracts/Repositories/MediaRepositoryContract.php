<?php

namespace App\Contracts\Repositories;

use App\Dto\Media\CreateMediaDto;
use App\Enums\Media\MediaTypeEnum;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;

interface MediaRepositoryContract
{
    public function store(CreateMediaDto $dto): Media;
    public function findByUuid(string $uuid): Media;
    public function findAllByProjectId(int $projectId): Collection;
    public function updateUploadStatusByUuid(string $uuid, bool $isUploaded): Media;
    public function findByTypeAndProjectId(int $projectId, MediaTypeEnum $type): Collection;
    public function deleteAllByProjectId(int $projectId): void;
}
