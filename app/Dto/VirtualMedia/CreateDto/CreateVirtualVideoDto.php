<?php

namespace App\Dto\VirtualMedia\CreateDto;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Dto\VirtualMedia\VirtualVideoDto;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\Models\VirtualVideo;

readonly class CreateVirtualVideoDto extends CreateVirtualMediaDto
{

    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration, int $projectId, public string $mediaUuid, public float $originalDuration)
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
            'width' => 0,
            'height' => 0,
            'crop_width' => 0,
            'crop_height' => 0,
            'x_position' => 0,
            'y_position' => 0
        ]);

        return new VirtualVideoDto(
            uuid: $this->uuid,
            layer: $this->layer,
            globalStartTime: $this->globalStartTime,
            startTime: $this->startTime,
            duration: $this->duration,
            mediaUuid: $this->mediaUuid,
            originalDuration: $this->originalDuration
        );
    }
}
