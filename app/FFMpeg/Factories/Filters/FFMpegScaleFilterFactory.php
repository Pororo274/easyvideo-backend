<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegScaleFilter;

class FFMpegScaleFilterFactory implements FFMpegFilterFactory
{
    public function createFilterFromModel(mixed $vm): FFMpegFilter
    {
        return new FFMpegScaleFilter(
            new Size($vm->width, $vm->height)
        );
    }

    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegScaleFilter(
            new Size($arr['ScaleFilter']['size']['width'], $arr['ScaleFilter']['size']['height'])
        );
    }
}
