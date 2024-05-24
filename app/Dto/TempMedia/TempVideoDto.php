<?php

namespace App\Dto\TempMedia;

use App\Dto\TempMedia\TempMediaDto;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Filters\FFMpegOverlayFilter;
use App\FFMpeg\Filters\FFMpegScaleFilter;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use function Ramsey\Uuid\v4;

readonly class TempVideoDto extends TempMediaDto
{
    public function __construct(string $mediaPath, float $globalStartTime, float $duration, int $layer, public Size $size, public Position $position)
    {
        parent::__construct($mediaPath, $globalStartTime, $duration, $layer);
    }

    public function insertIntoBlankMedia(TempMediaDto $dto): TempMediaDto
    {
        $output = "temp-media/easyvideo_" . v4() . ".mp4";

        FFMpeg::fromDisk('local')
            ->open([$dto->mediaPath, $this->mediaPath])
            ->addFilter(function (ComplexFilters $filters) {
                $filters
                    ->custom('[1]', (new FFMpegScaleFilter($this->size))->toString() . ',setpts=PTS-STARTPTS+'.$this->globalStartTime."/TB", '[v1]')
                    ->custom('[0:v][v1]', (new FFMpegOverlayFilter($this->position))->toString(), '[v0]')
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
            layer: $dto->layer,
            size: $dto->size,
            position: new Position(0, 0)
        );
    }
}
