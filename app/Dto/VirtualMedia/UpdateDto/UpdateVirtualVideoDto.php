<?php

namespace App\Dto\VirtualMedia\UpdateDto;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Dto\VirtualMedia\VirtualVideoDto;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\Models\VirtualVideo;

readonly class UpdateVirtualVideoDto extends UpdateVirtualMediaDto
{

    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration, public Position $position, public Size $size)
    {
        parent::__construct($uuid, $layer, $globalStartTime, $startTime, $duration);
    }
    public function update(): VirtualMediaDto
    {
        VirtualVideo::query()->where('uuid', $this->uuid)->update([
            'width' => $this->size->width,
            'height' => $this->size->height,
            'crop_width' => 0,
            'crop_height' => 0,
            'x_position' => $this->position->x,
            'y_position' => $this->position->y
        ]);
        $virtualVideo = VirtualVideo::query()->where('uuid', $this->uuid)->first();

        return new VirtualVideoDto(
            uuid: $this->uuid,
            layer: $this->layer,
            globalStartTime: $this->globalStartTime,
            startTime: $this->startTime,
            duration: $this->duration,
            mediaUuid: $virtualVideo->media_uuid,
            originalDuration: $virtualVideo->original_duration,
            position: $this->position,
            size: $this->size
        );
    }
}
