<?php

namespace App\FFMpeg\Filters;

readonly abstract class FFMpegFilter
{
    protected string $name;

    public function getName(): string
    {
        return $this->name;
    }
    public abstract function toArray(): array;
    public abstract function toString(): string;
}
