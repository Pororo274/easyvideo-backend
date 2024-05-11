<?php

namespace App\Contracts\Services;

use App\Dto\Media\SaveChunkDto;
use App\Models\Media;

interface MediaServiceContract
{
    public function saveChunk(SaveChunkDto $dto): Media;
}
