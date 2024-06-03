<?php

namespace App\Dto\VirtualMedia;

use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\FFMpeg\Filters\FFMpegFilterList;
use App\FFMpeg\Media\Inputs\FFMpegInput;

readonly abstract class VirtualMediaDto
{
    public array $filters;

    public function __construct(
        public string $uuid,
        public int $projectId,
        public int $layer,
        public VirtualMediaTypeEnum $contentType,
        public string $content,
        protected FFMpegFilterList $filterList
    ) {
        $this->filters = $filterList->toKeyedArray();
    }

    public abstract function getFFMpegInput(): FFMpegInput;
}
