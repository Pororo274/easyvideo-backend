<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Filters\FFMpegFilter;
use App\FFMpeg\Filters\FFMpegTextFilter;

class FFMpegTextFilterFactory implements FFMpegFilterFactory
{
    public function createFilterFromArray(array $arr): FFMpegFilter
    {
        return new FFMpegTextFilter(
            fontSize: $arr['text']['fontSize'],
            text: $arr['text']['text'] ?? ''
        );
    }
}
