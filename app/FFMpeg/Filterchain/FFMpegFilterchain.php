<?php

namespace App\FFMpeg\Filterchain;

use App\FFMpeg\Contracts\Executable;
use App\FFMpeg\Contracts\InputableMask;
use App\FFMpeg\Filters\FFMPegFilterList;
use Illuminate\Support\Collection;
use App\FFMpeg\Media\Inputs\FFMpegInput;

class FFMpegFilterchain implements Executable
{
    /**
     * @param Collection<FFMPegInput> $inputs
     */
    public function __construct(
        protected Collection $inputs,
        protected FFMPegFilterList $filterList
    ) {
    }

    public function toRawCommand(): string
    {
        return '';
    }

    public function getOutput(): InputableMask
    {
        return new FFMpegFilterchainOutput();
    }
}
