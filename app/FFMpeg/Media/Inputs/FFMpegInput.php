<?php

namespace App\FFMpeg\Media\Inputs;

use App\FFMpeg\Contracts\Maskable;
use App\FFMpeg\Enums\FFMpegStreamEnum;
use App\FFMpeg\Media\Streams\FFMpegStream;
use Illuminate\Support\Str;

readonly class FFMpegInput implements Maskable
{
    protected string $uuid;

    /**
     * @param string $path
     * @param FFMpegStream[] $streams
     */
    public function __construct(
        public string $path,
        public array $streams
    ) {
        $this->uuid = Str::random(10);
    }

//    public function toOrderedRawMask(int $order): string
//    {
//        return '[' . $order . ':' . $this->stream->getMask() . ']';
//    }

    public function toRawMask(): string
    {
        return '[' . $this->uuid . ']';
    }
}
