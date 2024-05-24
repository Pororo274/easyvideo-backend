<?php

namespace App\Dto\TempMedia;

use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Filters\FFMpegOverlayFilter;
use App\FFMpeg\Filters\FFMpegScaleFilter;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use function Ramsey\Uuid\v4;

readonly class TempImageDto extends TempMediaDto
{
    public function __construct(string $mediaPath, float $globalStartTime, float $duration, int $layer, public Size $size, public Position $position)
    {
        parent::__construct($mediaPath, $globalStartTime, $duration, $layer);
    }

    public function insertIntoBlankMedia(TempMediaDto $dto): TempMediaDto
    {
        $output = "temp-media/easyvideo_" . v4() . ".mp4";

        $endTime = $this->globalStartTime + $this->duration;

        FFMpeg::fromDisk('local')
            ->open([$dto->mediaPath, $this->mediaPath])
            ->addFilter(function (ComplexFilters $filters) use ($endTime) {
                $filters
                    ->custom('[1:v]', (new FFMpegScaleFilter($this->size))->toString(), '[v0]')
                    ->custom('[0:v][v0]', (new FFMpegOverlayFilter($this->position, $this->globalStartTime, $endTime))->toString(), '[v1]')
                    ->custom('[0:a]', 'anull', '[a2]');
            })
            ->export()
            ->addFormatOutputMapping(new X264, \ProtoneMedia\LaravelFFMpeg\Filesystem\Media::make('local', $output), ['[v1]', '[a2]'])
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
