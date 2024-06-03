<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\HasMultipleInputs;
use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Time;

class FFMpegOverlayFilter extends FFMpegFilter implements VideoFilter, HasMultipleInputs
{
    public function __construct(
        protected Position $position,
        protected Time $time
    ) {
        $this->name = 'OverlayFilter';
    }

    public function toString(): string
    {
        return "overlay=" . $this->position->x . ":" . $this->position->y . ":enable='between(t," . $this->time->delay . ',' . ($this->time->delay + $this->time->duration) . ")'";
    }

    public function toArray(): array
    {
        return [
            'position' => [
                'x' => $this->position->x,
                'y' => $this->position->y
            ],
            'time' => [
                'delay' => $this->time->delay,
                'startFrom' => $this->time->startFrom,
                'duration' => $this->time->duration
            ]
        ];
    }
}
