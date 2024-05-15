<?php

namespace App\Dto\Projects;

readonly class RenderJobEndedDto
{
    public function __construct(
        public int $userId,
        public int $projectId,
        public string $outputPath
    ) {
    }
}
