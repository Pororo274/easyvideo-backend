<?php

namespace App\Dto\VirtualMedia\CreateDto;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;

readonly abstract class CreateVirtualMediaDto
{
    public function __construct(
        public string $uuid,
        public int $layer,
        public float $globalStartTime,
        public float $startTime,
        public float $duration,
        public float $projectId,
    )
    {
    }

    public abstract function getType(): VirtualMediaTypeEnum;

    public abstract function store(): VirtualMediaDto;
}
