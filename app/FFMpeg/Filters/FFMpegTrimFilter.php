<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Coordinate\Time;
use App\FFMpeg\Filters\FFMpegFilter;

class FFMpegTrimFilter extends FFMpegFilter implements VideoFilter
{
    public function __construct(
        public Time $time
    ) {
        $this->name = 'TrimFilter';
    }

    public function toString(): string
    {
        return 'trim=' . $this->time->startFrom . ':' . $this->time->duration;
    }

    public function toArray(): array
    {
        return [
            'time' => $this->time
        ];
    }
}
