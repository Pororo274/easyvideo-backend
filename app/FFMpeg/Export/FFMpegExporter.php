<?php

namespace App\FFMpeg\Export;

use App\FFMpeg\Dto\ExporterDto;

class FFMpegExporter
{
    public function __construct(
        protected ExporterDto $dto
    ) {
    }

    public function export(): string
    {
        return '';
    }
}
