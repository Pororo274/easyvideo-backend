<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegScaleFilter;

class FFMpegScaleFilterFactory implements FFMpegFilterFactory
{
    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegScaleFilter(
            new Size($arr['size']['width'], $arr['size']['height'])
        );
    }
}
