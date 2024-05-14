<?php

namespace App\Dto\TempMedia;

use App\Dto\TempMedia\TempMediaDto;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use function Ramsey\Uuid\v4;

readonly class TempImageDto extends TempMediaDto
{
    public function insertIntoBlankMedia(TempMediaDto $dto): TempMediaDto
    {
        $output = "temp-media/easyvideo_" . v4() . ".mp4";

        $endTime = $this->globalStartTime + $this->duration;

        FFMpeg::fromDisk('local')
            ->open([$dto->mediaPath, $this->mediaPath])
            ->addFilter(function (ComplexFilters $filters) use ($endTime) {
                $filters
                    ->custom('[0:v][1:v]', "overlay=0:0:enable='between(t,". $this->globalStartTime .','. $endTime .")'", '[v0]')
                    ->custom('[0:a]', 'anull', '[a2]');
            })
            ->export()
            ->addFormatOutputMapping(new X264, \ProtoneMedia\LaravelFFMpeg\Filesystem\Media::make('local', $output), ['[v0]', '[a2]'])
            ->save();

        return new TempVideoDto(
            mediaPath: $output,
            globalStartTime: 0,
            duration: $dto->duration,
            layer: $dto->layer
        );
    }
}
