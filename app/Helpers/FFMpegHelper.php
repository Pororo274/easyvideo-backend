<?php

namespace App\Helpers;

use App\Dto\FFMpeg\TrimFilterDto;

class FFMpegHelper
{
    static function round(float $quantity): float
    {
        return floor($quantity * 100) / 100;
    }

    static function getTrimFilterCommand(TrimFilterDto $dto): string
    {
        return 'trim=' . FFMpegHelper::round($dto->start)  . ':' . FFMpegHelper::round($dto->end)  . ',setpts=PTS-STARTPTS';
    }

    static function getATrimFilterCommand(TrimFilterDto $dto): string
    {
        return 'atrim=' . FFMpegHelper::round($dto->start)  . ':' . FFMpegHelper::round($dto->end)  . ',asetpts=PTS-STARTPTS';
    }
}
