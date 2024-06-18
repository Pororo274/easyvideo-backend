<?php

namespace App\Contracts\Services;

use App\Dto\Media\CreateMediaDto;
use App\Dto\Media\MediaDto;
use App\Dto\Media\SaveChunkDto;
use App\Models\Media;
use Illuminate\Support\Collection;

interface MediaServiceContract
{
    public function saveChunk(SaveChunkDto $dto): Media;
    public function findAllByProjectId(int $projectId): Collection;
    public function findOneByUuid(string $uuid): MediaDto;
    public function store(CreateMediaDto $dto): MediaDto;
    public function getTotalSize(): float;
    public function getFilesByDirectory(string $directory): Collection;
}
