<?php

namespace App\Dto\Projects;

readonly class CreateProjectDto
{
    public function __construct(
        public string $name,
        public int $width,
        public int $height,
        public int $fps,
        public int $userId
    ) {
    }
}
