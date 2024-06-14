<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Time;
use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegOverlayFilter;
use Illuminate\Support\Facades\Log;

class FFMpegOverlayFilterFactory implements FFMpegFilterFactory
{

    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegOverlayFilter(
            position: new Position($arr['position']['x'], $arr['position']['y']),
            time: !isset($arr['time']) ? null : new Time($arr['time']['delay'], $arr['time']['startFrom'], $arr['time']['duration'])
        );
    }
}
