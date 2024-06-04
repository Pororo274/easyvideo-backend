<?php

namespace App\Dto\Projects;

readonly class UpdateProjectPreviewDto
{
    public function __construct(
        public int $projectId,
        public string $preview
    ) {
    }
}
