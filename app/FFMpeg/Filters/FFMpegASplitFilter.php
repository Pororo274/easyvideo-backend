<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\AudioFilter;
use App\FFMpeg\Filters\FFMpegFilter;

class FFMpegASplitFilter extends FFMpegFilter implements AudioFilter
{
    public function __construct(
        protected int $outputsCount
    ) {}

    public function toArray(): array
    {
        return [
            'outputs_count' => $this->outputsCount
        ];
    }

    public function toString(): string
    {
        return 'asplit='.$this->outputsCount;
    }
}
