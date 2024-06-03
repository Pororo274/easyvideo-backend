<?php

namespace App\FFMpeg\Media\Streams;

use App\FFMpeg\Contracts\AudioFilter;

class FFMpegAudioStream extends FFMpegStream
{
    protected string $filterType = AudioFilter::class;
    protected string $mask = 'a';

    public function createStream(): FFMpegStream
    {
        return new self();
    }
}
