<?php

namespace App\Dto\Media;

use App\Enums\Media\MediaTypeEnum;

readonly class CreateMediaDto
{
    public function __construct(
        public string $path,
        public int $projectId,
        public bool $isUploaded,
        public string $mediaUuid,
        public string $originalName,
        public MediaTypeEnum $type
    ) {
    }
}
