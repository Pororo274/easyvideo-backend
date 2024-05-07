<?php

namespace App\Dto\Projects;

readonly class ProjectConfigDto
{
    public function __construct(
        public int $width,
        public int $height,
        public int $fps = 25
    ) {
    }
}
