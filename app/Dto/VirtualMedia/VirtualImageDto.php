<?php

namespace App\Dto\VirtualMedia;

use App\FFMpeg\graph\FFMpegGraph;
use App\Models\Media;

readonly class VirtualImageDto extends VirtualMediaDto
{
    public function onMerge(FFMpegGraph $graph): void
    {
        $media = Media::query()->where('uuid', $this->content)->first();
    }
}
