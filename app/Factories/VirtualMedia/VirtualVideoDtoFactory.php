<?php

namespace App\Factories\VirtualMedia;

use App\Dto\VirtualMedia\VirtualVideoDto;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\Models\VirtualVideo;

readonly class VirtualVideoDtoFactory extends VirtualMediaDtoFactory
{
    public function factoryMethod(): VirtualVideoDto
    {
        $virtualVideo = VirtualVideo::query()->where('uuid', $this->virtualMedia->uuid)->first();

        return new VirtualVideoDto(
            uuid: $virtualVideo->uuid,
            layer: $this->virtualMedia->layer,
            globalStartTime: $this->virtualMedia->global_start_time,
            startTime: $this->virtualMedia->start_time,
            duration: $this->virtualMedia->duration,
            mediaUuid: $virtualVideo->media_uuid,
            originalDuration: $virtualVideo->original_duration,
            position: new Position($virtualVideo->x_position, $virtualVideo->y_position),
            size: new Size($virtualVideo->width, $virtualVideo->height)
        );
    }
}
