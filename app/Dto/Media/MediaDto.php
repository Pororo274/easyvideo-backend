<?php

namespace App\Dto\Media;

use App\Enums\Media\MediaStatusEnum;

readonly class MediaDto
{
    public function __construct(
        public string $uuid,
        public string $originalName,
        public string $type,
        public MediaStatusEnum $status,
        public string $objectURL,
        public int $uploadedBytes
    ) {
    }
}
