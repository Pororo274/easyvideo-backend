<?php

namespace App\Dto\VirtualMedia;

use App\Dto\Timeline\TimelineProperties;
use App\FFMpeg\Filters\FFMpegFilterList;
use App\FFMpeg\Media\Virtual\FFMpegVirtualMedia;

readonly abstract class VirtualMediaDto
{
    public array $filters;

    public function __construct(
        public TimelineProperties $timelineProperties,
        protected FFMpegFilterList $filterList
    ) {
        $this->filters = $filterList->toKeyedArray();
    }

    public abstract function toFFMpegVirtualMedia(): FFMpegVirtualMedia;
    public abstract function toArray(): array;
}
