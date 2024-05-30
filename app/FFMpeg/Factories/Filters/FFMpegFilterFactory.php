<?php

namespace App\FFMpeg\Factories\Filters;

use App\FFMpeg\Filters\FFMpegFilter;

interface FFMpegFilterFactory
{
    public function createFilterFromModel(mixed $vm): FFMpegFilter;
    public function createFilterFromArray(array $arr): FFMpegFilter;
}
