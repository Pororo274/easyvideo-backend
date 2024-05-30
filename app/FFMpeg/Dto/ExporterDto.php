<?php

namespace App\FFMpeg\Dto;

use Illuminate\Support\Collection;

readonly class ExporterDto
{
    public function __construct(
        public Collection $inputs,
        public Collection $virtualMedias
    ) {
    }
}
