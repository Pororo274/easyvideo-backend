<?php

namespace App\FFMpeg\Coordinate;

readonly class Position
{
    public function __construct(
        public float $x,
        public float $y
    )
    {
    }
}
