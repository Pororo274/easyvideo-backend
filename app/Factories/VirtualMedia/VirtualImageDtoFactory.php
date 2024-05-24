<?php

namespace App\Factories\VirtualMedia;

use App\Dto\VirtualMedia\VirtualImageDto;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\Models\VirtualImage;

readonly class VirtualImageDtoFactory extends VirtualMediaDtoFactory
{
    public function factoryMethod(): VirtualImageDto
    {
        $virtualImage = VirtualImage::query()->where('uuid', $this->virtualMedia->uuid)->first();

        return new VirtualImageDto(
            uuid: $virtualImage->uuid,
            layer: $this->virtualMedia->layer,
            globalStartTime: $this->virtualMedia->global_start_time,
            startTime: $this->virtualMedia->start_time,
            duration: $this->virtualMedia->duration,
            mediaUuid: $virtualImage->media_uuid,
            position: new Position($virtualImage->x_position, $virtualImage->y_position),
            size: new Size($virtualImage->width, $virtualImage->height)
        );
    }
}
