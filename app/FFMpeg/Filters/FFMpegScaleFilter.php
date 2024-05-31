<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Filters\FFMpegFilter;

class FFMpegScaleFilter extends FFMpegFilter implements VideoFilter
{
    public function __construct(
        protected Size $size
    ) {
        $this->name = 'ScaleFilter';
    }

    public function toString(): string
    {
        return "scale=" . $this->size->width . ":" . $this->size->height;
    }

    public function toArray(): array
    {
        return [
            'size' => [
                'width' => $this->size->width,
                'height' => $this->size->height
            ]
        ];
    }
}
