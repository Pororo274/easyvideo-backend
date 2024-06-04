<?php

namespace App\Dto\Projects;

use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\Compound;

readonly class ProjectDto
{
    public function __construct(
        public int $id,
        public string $name,
        public int $width,
        public int $height,
        public int $fps,
        public int $userId,
        public ?string $preview,
        public Carbon $createdAt
    ) {
    }
}
