<?php

namespace App\FFMpeg\Media\Virtual;

use App\FFMpeg\Dto\MediaMergeDto;

readonly abstract class FFMpegVirtualMedia
{
    public function __construct(
        protected MediaMergeDto $dto
    ) {
    }

    public abstract function onMerge(): void;
}
