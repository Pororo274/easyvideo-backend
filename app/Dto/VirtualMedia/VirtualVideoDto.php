<?php

namespace App\Dto\VirtualMedia;

use App\Dto\Timeline\TimelineProperties;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\FFMpeg\Dto\MediaMergeDto;
use App\FFMpeg\Filters\FFMpegFilterList;
use App\FFMpeg\Media\Inputs\FFMpegInput;
use App\FFMpeg\Media\Virtual\FFMpegVirtualMedia;
use App\FFMpeg\Media\Virtual\FFMpegVirtualVideo;
use App\Models\Media;

readonly class VirtualVideoDto extends VirtualMediaDto
{
    public function toFFMpegVirtualMedia(): FFMpegVirtualMedia
    {
        $media = Media::query()->where('uuid', $this->content)->first();

        return new FFMpegVirtualVideo(
            new MediaMergeDto(
                input: new FFMpegInput($media->path),
                filterList: FFMpegFilterList::fromArrayToFilterList($this->filters)
            )
        );
    }
}
