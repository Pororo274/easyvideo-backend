<?php

namespace App\FFMpeg\Enums;

enum FFMpegStreamEnum: string
{
    case VideoStream = 'v';
    case AudioStream = 'a';
}
