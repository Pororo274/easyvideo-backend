<?php

namespace App\FFMpeg\Contracts;

interface Executable
{
    public function toRawCommand(): string;
}
