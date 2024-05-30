<?php

namespace App\FFMpeg\Filterchain;

use App\FFMpeg\Contracts\InputableMask;

class FFMpegFilterchainOutput implements InputableMask
{
    public function toRawMask(): string
    {
        return '';
    }
}
