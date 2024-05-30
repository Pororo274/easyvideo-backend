<?php

namespace App\FFMpeg\Media\Inputs;

use Illuminate\Support\Collection;

class FFMpegVideoInput extends FFMpegInput
{
    public function getInputMasks(): Collection
    {
        return collect([
            new FFMpegInputMask($this->order, 'v'),
        ]);
    }
}
