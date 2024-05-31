<?php

namespace App\FFMpeg\Coordinate;

readonly class Time
{
    public function __construct(
        public float $delay,
        public float $startFrom,
        public float $duration
    ) {
    }
}
