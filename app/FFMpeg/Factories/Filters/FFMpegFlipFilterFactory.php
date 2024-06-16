<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Factories\Filters\FFMpegFilterFactory;
use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegFlipFilter;
use Illuminate\Support\Facades\Log;

class FFMpegFlipFilterFactory implements FFMpegFilterFactory
{

    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegFlipFilter(
            h: $arr['flip']['h'] ?? false,
            v: $arr['flip']['v'] ?? false
        );
    }
}
