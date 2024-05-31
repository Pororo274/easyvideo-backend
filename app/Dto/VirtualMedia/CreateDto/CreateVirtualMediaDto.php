<?php

namespace App\Dto\VirtualMedia\CreateDto;

use App\Enums\VirtualMedia\VirtualMediaTypeEnum;

readonly class CreateVirtualMediaDto
{
    public function __construct(
        public string $uuid,
        public int $projectId,
        public int $layer,
        public VirtualMediaTypeEnum $contentType,
        public string $content,
        public array $filters
    ) {
    }
}
