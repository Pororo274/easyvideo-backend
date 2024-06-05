<?php

namespace App\FFMpeg\Media\Inputs;

use App\FFMpeg\Media\Streams\FFMpegStream;

readonly class FFMpegInput
{
    protected string $uuid;

    /**
     * @param string $path
     * @param FFMpegStream[] $streams
     */
    public function __construct(
        public string $path,
        public array $streams,
        public array $beforeSplitFilters = []
    ) {
    }

    //    public function toOrderedRawMask(int $order): string
    //    {
    //        return '[' . $order . ':' . $this->stream->getMask() . ']';
    //    }
}
