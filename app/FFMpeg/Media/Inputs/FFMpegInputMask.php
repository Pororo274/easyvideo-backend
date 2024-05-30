<?php

namespace App\FFMpeg\Media\Inputs;

use App\FFMpeg\Contracts\InputableMask;

class FFMpegInputMask implements InputableMask
{
    public function __construct(
        protected int $order,
        protected string $stream
    ) {
    }

    public function toRawMask(): string
    {
        return '[' . $this->order . ':' . $this->stream . ']';
    }
}
