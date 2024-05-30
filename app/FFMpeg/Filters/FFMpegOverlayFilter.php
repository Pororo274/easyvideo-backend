<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Coordinate\Position;

readonly class FFMpegOverlayFilter extends FFMpegFilter implements VideoFilter
{
    public function __construct(
        public Position $position,
        public ?float $startTime = null,
        public ?float $endTime = null
    ) {
        $this->name = 'OverlayFilter';
    }

    public function toString(): string
    {
        if (is_null($this->startTime) && is_null($this->endTime)) {
            return "overlay=" . $this->position->x . ":" . $this->position->y;
        }

        return "overlay=" . $this->position->x . ":" . $this->position->y . ":enable='between(t," . $this->startTime . ',' . $this->endTime . ")'";
    }

    public function toArray(): array
    {
        return [
            'x_position' => $this->position->x,
            'y_position' => $this->position->y
        ];
    }
}
