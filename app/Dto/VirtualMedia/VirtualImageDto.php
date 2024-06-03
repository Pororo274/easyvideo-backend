<?php

namespace App\Dto\VirtualMedia;

use App\FFMpeg\Media\Inputs\FFMpegInput;
use App\FFMpeg\Media\Streams\FFMpegVideoStream;
use App\Models\Media;

readonly class VirtualImageDto extends VirtualMediaDto
{
    public function getFFMpegInput(): FFMpegInput
    {
        $media = Media::query()->where('uuid', $this->content)->first();

        return new FFMpegInput(
            path: $media->path,
            streams: [new FFMpegVideoStream]
        );
    }
}
