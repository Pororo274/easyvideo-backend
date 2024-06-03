<?php

namespace App\FFMpeg\Filterchain;

use App\FFMpeg\Contracts\Maskable;
use Illuminate\Support\Str;

class FFMpegFilterchainOutput implements Maskable
{
    protected string $outputName;

    public function __construct(
    ) {
        $this->outputName = Str::random(10);
    }

    public function toRawMask(): string
    {
        return '['.$this->outputName.']';
    }
}
