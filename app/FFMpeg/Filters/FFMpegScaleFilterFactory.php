<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegScaleFilter;

class FFMpegScaleFilterFactory implements FFMpegFilterFactory
{
    public function factoryMethod(mixed $vm): FFMpegFilter
    {
        return new FFMpegScaleFilter(
            new Size($vm->width, $vm->height)
        );
    }
}
