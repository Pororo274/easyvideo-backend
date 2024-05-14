<?php

namespace App\Dto\Projects;

use App\Dto\VirtualMedia\VirtualMediaDto;

readonly class ProjectRenderJobDto
{

    /**
     * @param int $projectId
     * @param VirtualMediaDto[] $virtualMedias
     */
    public function __construct(
        public int $projectId,
        public int $width,
        public int $height,
        public array $virtualMedias
    )
    {
    }
}
