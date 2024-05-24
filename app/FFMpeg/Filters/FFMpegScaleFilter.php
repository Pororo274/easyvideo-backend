<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Filters\FFMpegFilter;

class FFMpegScaleFilter extends FFMpegFilter
{
    public function __construct(
        public Size $size
    ) {}
    public function toString(): string
    {
        return "scale=". $this->size->width .":". $this->size->height;
    }
}
