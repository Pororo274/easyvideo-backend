<?php

namespace App\FFMpeg\Coordinate;

readonly class Size
{
    public function __construct(
        public float $width,
        public float $height
    )
    {
    }
}
