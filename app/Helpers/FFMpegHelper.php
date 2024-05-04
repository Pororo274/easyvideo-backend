<?php

namespace App\Helpers;

class FFMpegHelper
{
    static function round(float $quantity): float
    {
        return floor($quantity * 100) / 100;
    }
}
