<?php

namespace App\Dto\Timeline;

readonly class TimelineProperties
{
    public function __construct(
        public string $uuid,
        public int $layer,
        public float $globalStartTime,
        public float $startTime,
        public float $duration,
    ) {
    }
}
