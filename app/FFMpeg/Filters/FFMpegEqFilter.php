<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Filters\FFMpegFilter;

class FFMpegEqFilter extends FFMpegFilter implements VideoFilter
{
    public function __construct(
        protected float $opacity,
    )
    {}

    public function toArray(): array
    {
        return [
            'opacity' => [
                'value' => $this->opacity
            ],
        ];
    }

    public function toString(): string
    {
        return 'colorchannelmixer=aa=' . 1;
    }
}
