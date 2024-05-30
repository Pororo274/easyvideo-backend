<?php

namespace App\FFMpeg\Contracts;

interface InputableMask
{
    public function toRawMask(): string;
}
