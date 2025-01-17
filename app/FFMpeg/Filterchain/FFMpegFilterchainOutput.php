<?php

namespace App\FFMpeg\Filterchain;

use App\FFMpeg\Contracts\Maskable;
use Illuminate\Support\Str;

class FFMpegFilterchainOutput implements Maskable
{
    public function __construct(
        protected Maskable $mask
    ) {
    }

    public function toRawMask(): string
    {
        return $this->mask;
    }
}
