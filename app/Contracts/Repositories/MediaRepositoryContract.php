<?php

namespace App\Contracts\Repositories;

use App\Dto\Media\CreateMediaDto;
use App\Models\Media;

interface MediaRepositoryContract
{
    public function store(CreateMediaDto $dto): Media;
    public function findByUuid(string $uuid): Media;
    public function updateUploadStatusByUuid(string $uuid, bool $isUploaded): Media;
}
