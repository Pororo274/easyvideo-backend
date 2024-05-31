<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Coordinate\Time;
use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegTrimFilter;

class FFMpegTrimFilterFactory implements FFMpegFilterFactory
{
    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegTrimFilter(
            new Time($arr['TrimFilter']['time']['delay'], $arr['TrimFilter']['time']['startFrom'], $arr['TrimFilter']['time']['duration'])
        );
    }
}
