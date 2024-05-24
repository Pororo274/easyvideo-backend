<?php

namespace App\Dto\VirtualMedia\UpdateDto;

use App\Dto\VirtualMedia\VirtualImageDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\Models\VirtualImage;

readonly class UpdateVirtualImageDto extends UpdateVirtualMediaDto
{

    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration, public Position $position, public Size $size)
    {
        parent::__construct($uuid, $layer, $globalStartTime, $startTime, $duration);
    }
    public function update(): VirtualMediaDto
    {
        VirtualImage::query()->where('uuid', $this->uuid)->update([
            'width' => $this->size->width,
            'height' => $this->size->height,
            'crop_width' => 0,
            'crop_height' => 0,
            'x_position' => $this->position->x,
            'y_position' => $this->position->y
        ]);

        $virtualImage = VirtualImage::query()->where('uuid', $this->uuid)->first();

        return new VirtualImageDto(
            uuid: $this->uuid,
            layer: $this->layer,
            globalStartTime: $this->globalStartTime,
            startTime: $this->startTime,
            duration: $this->duration,
            mediaUuid: $virtualImage->media_uuid,
            position: $this->position,
            size: $this->size
        );
    }
}
