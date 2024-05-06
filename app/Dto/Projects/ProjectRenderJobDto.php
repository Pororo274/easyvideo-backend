<?php

namespace App\Dto\Projects;

readonly class ProjectRenderJobDto
{
    public function __construct(
        public int $projectId,
        public array $nodes
    )
    {
    }
}
