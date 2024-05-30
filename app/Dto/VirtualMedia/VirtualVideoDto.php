<?php

namespace App\Dto\VirtualMedia;

use App\Dto\Timeline\TimelineProperties;
use App\FFMpeg\Dto\MediaMergeDto;
use App\FFMpeg\Filters\FFMpegFilterList;
use App\FFMpeg\Media\Inputs\FFMpegInput;
use App\FFMpeg\Media\Virtual\FFMpegVirtualMedia;
use App\FFMpeg\Media\Virtual\FFMpegVirtualVideo;
use App\Models\Media;

readonly class VirtualVideoDto extends VirtualMediaDto
{
    public function __construct(
        public TimelineProperties $timelineProperties,
        protected FFMpegFilterList $filterList,
        public float $originalDuration,
        public string $mediaUuid
    ) {
        parent::__construct($timelineProperties, $filterList);
    }

    public function toFFMpegVirtualMedia(): FFMpegVirtualMedia
    {
        $media = Media::query()->where('uuid', $this->mediaUuid)->first();

        return new FFMpegVirtualVideo(
            new MediaMergeDto(
                input: new FFMpegInput($media->path),
                filterList: FFMpegFilterList::fromArrayToFilterList($this->filters)
            )
        );
    }

    public function toArray(): array
    {
        $filters = [];

        $arrayedFilterList = $this->filterList->toArray();

        foreach ($arrayedFilterList as $filter) {
            $filters = [...$filters, ...$filter->toArray()];
        }

        return [
            'media_uuid' => $this->mediaUuid,
            'original_duration' => $this->originalDuration,
            ...$arrayedFilterList
        ];
    }
}
