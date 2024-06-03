<?php

namespace App\FFMpeg\Media\Streams;

abstract class FFMpegStream
{
    protected string $filterType;
    protected string $mask;

    public function getMask(): string
    {
        return $this->mask;
    }

    public function getFilterType(): string
    {
        return $this->filterType;
    }
}
