<?php

namespace App\Dto\VirtualMedia\CreateDto;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Dto\VirtualMedia\VirtualVideoDto;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\Models\VirtualVideo;

readonly class CreateVirtualVideoDto extends CreateVirtualMediaDto
{

    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration, int $projectId, public string $mediaUuid, public float $originalDuration, public Position $position, public Size $size)
    {
        parent::__construct($uuid, $layer, $globalStartTime, $startTime, $duration, $projectId);
    }

    public function getType(): VirtualMediaTypeEnum
    {
        return VirtualMediaTypeEnum::VirtualVideo;
    }

    public function store(): VirtualMediaDto
    {
        VirtualVideo::query()->create([
            'uuid' => $this->uuid,
            'original_duration' => $this->originalDuration,
            'media_uuid' => $this->mediaUuid,
            'width' => $this->size->width,
            'height' => $this->size->height,
            'crop_width' => 0,
            'crop_height' => 0,
            'x_position' => $this->position->x,
            'y_position' => $this->position->y
        ]);

        return new VirtualVideoDto(
            uuid: $this->uuid,
            layer: $this->layer,
            globalStartTime: $this->globalStartTime,
            startTime: $this->startTime,
            duration: $this->duration,
            mediaUuid: $this->mediaUuid,
            originalDuration: $this->originalDuration,
            position: $this->position,
            size: $this->size
        );
    }
}
