<?php

namespace App\Dto\VirtualMedia;

use App\Dto\TempMedia\TempImageDto;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\Models\Media;

readonly class VirtualImageDto extends VirtualMediaDto
{
    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration, public string $mediaUuid, public Position $position, public Size $size)
    {
        parent::__construct($uuid, $layer, $globalStartTime, $startTime, $duration);
    }

    public function createTempMedia(): TempImageDto
    {
        $media = Media::query()->where('uuid', $this->mediaUuid)->first();

        return new TempImageDto(
            mediaPath: $media->path,
            globalStartTime: $this->globalStartTime,
            duration: $this->duration,
            layer: $this->layer,
            size: $this->size,
            position: $this->position,
        );
    }
}
