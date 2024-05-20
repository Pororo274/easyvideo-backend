<?php

namespace App\Dto\VirtualMedia;

use App\Dto\TempMedia\TempMediaDto;

readonly abstract class VirtualMediaDto
{
    public function __construct(
        public string $uuid,
        public int $layer,
        public float $globalStartTime,
        public float $startTime,
        public float $duration,
    ) {}

    public abstract function render(): TempMediaDto;

    public function getEndTime(): float
    {
        return $this->startTime + $this->duration;
    }
}
