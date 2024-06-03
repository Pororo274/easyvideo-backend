<?php

namespace App\Dto\Projects;

readonly class ExportJobEndedDto
{
    public function __construct(
        public int $userId,
        public int $projectId,
        public string $link
    ) {
    }
}
