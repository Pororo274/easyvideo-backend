<?php

namespace App\FFMpeg\Media\Inputs;

use App\FFMpeg\Contracts\Maskable;

class FFMpegMask implements Maskable
{
    public function __construct(
        protected string $mask
    ) {
    }

    public function toRawMask(): string
    {
        return $this->mask;
    }
}
