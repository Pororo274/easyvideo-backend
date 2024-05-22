<?php

namespace App\Factories\VirtualMedia;

use App\Dto\VirtualMedia\VirtualImageDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Factories\VirtualMedia\VirtualMediaDtoFactory;
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
        );
    }
}
