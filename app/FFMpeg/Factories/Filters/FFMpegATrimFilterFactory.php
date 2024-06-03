<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Coordinate\Time;
use App\FFMpeg\Filters\FFMpegATrimFilter;
use App\FFMpeg\Filters\FFMpegFilter;

class FFMpegATrimFilterFactory extends FFMpegTrimFilterFactory
{
    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegATrimFilter(
            new Time($arr['ATrimFilter']['time']['delay'], $arr['ATrimFilter']['time']['startFrom'], $arr['ATrimFilter']['time']['duration'])
        );
    }
}
