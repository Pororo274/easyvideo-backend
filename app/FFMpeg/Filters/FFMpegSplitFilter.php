<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;

class FFMpegSplitFilter extends FFMpegFilter implements VideoFilter
{
    public function __construct(
        protected int $outputsCount
    ) {}
    public function toString(): string
    {
        return 'split='.$this->outputsCount;
    }

    public function toArray(): array
    {
        return [
            'outputsCount' => $this->outputsCount
        ];
    }
}
