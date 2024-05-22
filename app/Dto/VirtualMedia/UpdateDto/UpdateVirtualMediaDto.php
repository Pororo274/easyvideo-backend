<?php

namespace App\Dto\VirtualMedia\UpdateDto;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;

readonly abstract class UpdateVirtualMediaDto
{
    public function __construct(
        public string $uuid,
        public int $layer,
        public float $globalStartTime,
        public float $startTime,
        public float $duration,
    )
    {
    }

    public abstract function update(): VirtualMediaDto;
}
