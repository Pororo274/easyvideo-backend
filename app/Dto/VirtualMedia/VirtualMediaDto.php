<?php

namespace App\Dto\VirtualMedia;

use App\Contracts\Repositories\MediaRepositoryContract;
use App\Dto\TempMedia\TempMediaDto;
use App\Repositories\MediaRepository;

readonly abstract class VirtualMediaDto
{
    public function __construct(
        public string $uuid,
        public int $layer,
        public float $globalStartTime,
        public float $startTime,
        public float $duration,
    ) {}

    public abstract function createTempMedia(): TempMediaDto;

    public function getEndTime(): float
    {
        return $this->startTime + $this->duration;
    }
}
