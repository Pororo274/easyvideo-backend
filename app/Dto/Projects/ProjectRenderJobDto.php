<?php

namespace App\Dto\Projects;

use App\Dto\VirtualMedia\VirtualMediaDto;
use Illuminate\Support\Collection;

readonly class ProjectRenderJobDto
{

    /**
     * @param int $projectId
     * @param Collection<VirtualMediaDto> $virtualMedias
     */
    public function __construct(
        public int $userId,
        public int $projectId,
        public int $width,
        public int $height,
        public bool $subscription
    ) {
    }
}
