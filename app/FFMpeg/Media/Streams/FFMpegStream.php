<?php

namespace App\FFMpeg\Media\Streams;

use App\FFMpeg\Contracts\Maskable;
use Illuminate\Support\Str;

abstract class FFMpegStream implements Maskable
{
    protected string $filterType;
    protected string $mask;
    protected string $uuid;

    public function __construct()
    {
        $this->uuid = Str::random(10);
    }

    public function getMask(): string
    {
        return $this->mask;
    }

    public function getFilterType(): string
    {
        return $this->filterType;
    }

    public function toRawMask(): string
    {
        return '[' . $this->uuid . ']';
    }

    public abstract function createStream(): self;
}
