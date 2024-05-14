<?php

namespace App\Dto\TempMedia;

use App\Dto\TempMedia\TempMediaDto;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use function Ramsey\Uuid\v4;

readonly class TempVideoDto extends TempMediaDto
{
    public function insertIntoBlankMedia(TempMediaDto $dto): TempMediaDto
    {
        $output = "temp-media/easyvideo_" . v4() . ".mp4";

        FFMpeg::fromDisk('local')
            ->open([$dto->mediaPath, $this->mediaPath])
            ->addFilter(function (ComplexFilters $filters) {
                $filters
                    ->custom('[1]', 'scale=640:-1,setpts=PTS-STARTPTS+'.$this->globalStartTime."/TB", '[v1]')
                    ->custom('[0:v][v1]', 'overlay=0:0', '[v0]')
                    ->custom('[1:a]', 'adelay='. ($this->globalStartTime * 1000) .':all=1', '[a1]')
                    ->custom('[0:a][a1]', "amix=inputs=2", "[a2]");

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
