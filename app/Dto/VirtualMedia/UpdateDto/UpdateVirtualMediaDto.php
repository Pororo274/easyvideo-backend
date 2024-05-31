<?php

namespace App\Dto\VirtualMedia\UpdateDto;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;

readonly class UpdateVirtualMediaDto
{
    public function __construct(
        public string $uuid,
        public int $layer,
        public VirtualMediaTypeEnum $contentType,
        public string $content,
        public array $filters
    ) {
    }
}
