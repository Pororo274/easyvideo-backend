<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\AudioFilter;
use App\FFMpeg\Coordinate\Time;

class FFMpegATrimFilter extends FFMpegFilter implements AudioFilter
{
    protected string $name = 'ATrimFilter';

    public function __construct(
        protected Time $time
    ) {
    }

    public function toArray(): array
    {
        return [
            'time' => $this->time
        ];
    }

    public function toString(): string
    {
        return 'atrim=' . $this->time->startFrom . ':' . $this->time->startFrom + $this->time->duration . ',asetpts=PTS-STARTPTS';
    }
}
