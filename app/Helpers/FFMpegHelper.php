<?php

namespace App\Helpers;

use App\Dto\FFMpeg\CreateBlankVideoDto;
use App\Dto\TempMedia\TempVideoDto;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class FFMpegHelper
{
    const BLANK_PATH = "helpers/blank.jpg";

    static function round(float $quantity): float
    {
        return floor($quantity * 100) / 100;
    }

    static function createBlankVideo(CreateBlankVideoDto $dto): TempVideoDto
    {
        $format = new X264();

        $format->setInitialParameters([
            "-f", "lavfi",
            "-i", "anullsrc",
            "-loop", "1",
        ]);

        //TODO: add resolution set
        FFMpeg::fromDisk('local')
            ->open(static::BLANK_PATH)
            ->addFilter('-t', $dto->duration)
            ->addFilter('-shortest')
            ->addFilter('-vf', 'scale=' . $dto->width. ':' . $dto->height .',setdar=16/9')
            ->addFilter('-pix_fmt', 'yuv420p')
            ->export()
            ->inFormat($format)
            ->toDisk('local')
            ->save($dto->outputPath);

        return new TempVideoDto(
            mediaPath: $dto->outputPath,
            globalStartTime: 0,
            duration: $dto->duration,
            layer: 9999,
            size: new Size($dto->width, $dto->height),
            position: new Position(0, 0)
        );
    }
}
