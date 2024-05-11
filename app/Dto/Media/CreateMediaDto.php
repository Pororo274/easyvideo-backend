<?php

namespace App\Dto\Media;


readonly class CreateMediaDto
{
    public function __construct(
        public string $path,
        public int $projectId,
        public bool $isUploaded
    ) {
    }
}
