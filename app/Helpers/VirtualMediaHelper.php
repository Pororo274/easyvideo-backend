<?php

namespace App\Helpers;

use App\Dto\VirtualMedia\VirtualImageDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Dto\VirtualMedia\VirtualVideoDto;

class VirtualMediaHelper
{
    static function toDtoFromArray(array $virtualMedia): VirtualMediaDto
    {
        if (isset($virtualMedia['originalDuration'])) {
            return new VirtualVideoDto(
                uuid: $virtualMedia['id'],
                layer: $virtualMedia['layer'],
                globalStartTime: $virtualMedia['globalStartTime'],
                startTime: $virtualMedia['startTime'],
                duration: $virtualMedia['duration'],
                mediaPath: $virtualMedia['mediaPath'],
                originalDuration: $virtualMedia['originalDuration']
            );
        }
        return new VirtualImageDto(
            uuid: $virtualMedia['id'],
            layer: $virtualMedia['layer'],
            globalStartTime: $virtualMedia['globalStartTime'],
            startTime: $virtualMedia['startTime'],
            duration: $virtualMedia['duration'],
            mediaPath: $virtualMedia['mediaPath'],
        );
    }
}
