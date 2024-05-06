<?php

namespace App\Dto\FFMpeg;

readonly class TrimFilterDto
{
    public function __construct(
        public float $start,
        public float $end,
    )
    {}
}
