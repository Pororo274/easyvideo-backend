<?php

namespace App\FFMpeg\Filters;

abstract class FFMpegFilter
{
    protected string $name;

    public abstract function toArray(): array;
    public abstract function toString(): string;
}
