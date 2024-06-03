<?php

namespace App\FFMpeg\Media\Streams;

use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Media\Streams\FFMpegStream;

class FFMpegVideoStream extends FFMpegStream
{
    protected string $filterType = VideoFilter::class;
    protected string $mask = 'v';
}
