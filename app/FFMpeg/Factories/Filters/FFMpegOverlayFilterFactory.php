<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegOverlayFilter;

class FFMpegOverlayFilterFactory implements FFMpegFilterFactory
{
    public function createFilterFromModel(mixed $vm): FFMpegFilter
    {
        return new FFMpegOverlayFilter(
            new Position($vm->x_position, $vm->y_position)
        );
    }

    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegOverlayFilter(
            new Position($arr['OverlayFilter']['position']['x'], $arr['OverlayFilter']['position']['y'])
        );
    }
}
