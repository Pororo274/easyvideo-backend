<?php

namespace App\FFMpeg\Contracts;

interface Maskable
{
    public function toRawMask(): string;
}
