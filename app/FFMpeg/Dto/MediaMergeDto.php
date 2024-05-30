<?php

namespace App\FFMpeg\Dto;

use App\FFMpeg\Filters\FFMpegFilterList;
use App\FFMpeg\Media\Inputs\FFMpegInput;

readonly class MediaMergeDto
{
    public function __construct(
        protected FFMpegInput $input,
        protected FFMpegFilterList $filterList
    ) {
    }
}
