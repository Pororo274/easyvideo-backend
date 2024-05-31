<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Time;
use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegOverlayFilter;

class FFMpegOverlayFilterFactory implements FFMpegFilterFactory
{

    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegOverlayFilter(
            new Position($arr['OverlayFilter']['position']['x'], $arr['OverlayFilter']['position']['y']),
            new Time($arr['OverlayFilter']['time']['delay'], $arr['OverlayFilter']['time']['startFrom'], $arr['OverlayFilter']['time']['duration'])
        );
    }
}
