<?php

namespace App\Dto\VirtualMedia;

use App\FFMpeg\Media\Inputs\FFMpegInput;
use App\FFMpeg\Media\Streams\FFMpegVideoStream;

readonly class WatermarkDto extends VirtualMediaDto
{
    public function getFFMpegInput(): FFMpegInput
    {
        return new FFMpegInput(
            path: $this->content,
            streams: [new FFMpegVideoStream]
        );
    }
}
