<?php

namespace App\Dto\VirtualMedia\UpdateDto;

use App\Dto\VirtualMedia\VirtualImageDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\Models\VirtualImage;

readonly class UpdateVirtualImageDto extends UpdateVirtualMediaDto
{

    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration)
    {
        parent::__construct($uuid, $layer, $globalStartTime, $startTime, $duration);
    }
    public function update(): VirtualMediaDto
    {
        VirtualImage::query()->where('uuid', $this->uuid)->update([
            'width' => 0,
            'height' => 0,
            'crop_width' => 0,
            'crop_height' => 0,
            'x_position' => 0,
            'y_position' => 0
        ]);

        $virtualImage = VirtualImage::query()->where('uuid', $this->uuid)->first();

        return new VirtualImageDto(
            uuid: $this->uuid,
            layer: $this->layer,
            globalStartTime: $this->globalStartTime,
            startTime: $this->startTime,
            duration: $this->duration,
            mediaUuid: $virtualImage->media_uuid,
        );
    }
}
