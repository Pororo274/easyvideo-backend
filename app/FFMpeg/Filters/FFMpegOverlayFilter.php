<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Coordinate\Position;

class FFMpegOverlayFilter extends FFMpegFilter
{
    public function __construct(
        public Position $position,
        public ?float $startTime = null,
        public ?float $endTime = null
    )
    {
    }

    public function toString(): string
    {
        if (is_null($this->startTime) && is_null($this->endTime)) {
            return "overlay=" . $this->position->x . ":" . $this->position->y;
        }

        return "overlay=" . $this->position->x . ":" . $this->position->y . ":enable='between(t,". $this->startTime .','. $this->endTime .")'";
    }
}
