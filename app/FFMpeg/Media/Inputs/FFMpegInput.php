<?php

namespace App\FFMpeg\Media\Inputs;

class FFMpegInput
{
    public function __construct(
        protected string $path,
    ) {
    }
}
