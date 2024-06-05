<?php

namespace App\Dto\VirtualMedia;

use App\FFMpeg\Media\Inputs\FFMpegInput;
use App\FFMpeg\Media\Streams\FFMpegVideoStream;

readonly class VirtualTextDto extends VirtualMediaDto
{
    public function getFFMpegInput(): FFMpegInput
    {
        return new FFMpegInput(
            path: "helpers/blank.jpg",
            streams: [new FFMpegVideoStream]
        );
    }
}
