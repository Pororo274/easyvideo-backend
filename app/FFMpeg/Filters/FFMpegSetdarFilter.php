<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Coordinate\Size;

class FFMpegSetdarFilter extends FFMpegFilter implements VideoFilter
{
    public function __construct(
        protected Size $size
    ) {
        $this->name = 'SetdarFilter';
    }

    public function toString(): string
    {
        return "setdar=dar=" . ($this->size->width / $this->size->height);
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
