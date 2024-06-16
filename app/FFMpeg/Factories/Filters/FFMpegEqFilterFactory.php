<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Factories\Filters\FFMpegFilterFactory;
use App\FFMpeg\Filters\FFMpegEqFilter;
use App\FFMpeg\Filters\FFMpegFilter;

class FFMpegEqFilterFactory implements FFMpegFilterFactory
{

    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegEqFilter(
            opacity: $arr['opacity']['value'],
        );
    }
}
