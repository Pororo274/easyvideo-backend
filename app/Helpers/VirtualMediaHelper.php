<?php

namespace App\Helpers;

use App\Dto\VirtualMedia\CreateDto\CreateVirtualImageDto;
use App\Dto\VirtualMedia\CreateDto\CreateVirtualMediaDto;
use App\Dto\VirtualMedia\CreateDto\CreateVirtualVideoDto;
use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualImageDto;
use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualMediaDto;
use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualVideoDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\Models\VirtualMedia;
use Illuminate\Support\Collection;

class VirtualMediaHelper
{

    static function getDtoFromVirtualMedia(VirtualMedia $virtualMedia): VirtualMediaDto
    {
        $factory = $virtualMedia->type->getFactory($virtualMedia);

        return $factory->factoryMethod();
    }

    static function getUpdateDtoFromCollection(Collection $virtualMedia): UpdateVirtualMediaDto
    {
        if ($virtualMedia->has('originalDuration')) {
            return new UpdateVirtualVideoDto(
                uuid: $virtualMedia->get('uuid'),
                layer: $virtualMedia->get('layer'),
                globalStartTime: $virtualMedia->get('globalStartTime'),
                startTime: $virtualMedia->get('startTime'),
                duration: $virtualMedia->get('duration'),
                position: new Position($virtualMedia->get('position')['x'], $virtualMedia->get('position')['y']),
                size: new Size($virtualMedia->get('size')['width'], $virtualMedia->get('size')['height'])
            );
        }

        return new UpdateVirtualImageDto(
            uuid: $virtualMedia->get('uuid'),
            layer: $virtualMedia->get('layer'),
            globalStartTime: $virtualMedia->get('globalStartTime'),
            startTime: $virtualMedia->get('startTime'),
            duration: $virtualMedia->get('duration'),
            position: new Position($virtualMedia->get('position')['x'], $virtualMedia->get('position')['y']),
            size: new Size($virtualMedia->get('size')['width'], $virtualMedia->get('size')['height'])
        );
    }

    static function getCreateDtoFromCollection(Collection $virtualMedia): CreateVirtualMediaDto
    {
        if ($virtualMedia->has('originalDuration')) {
            return new CreateVirtualVideoDto(
                uuid: $virtualMedia->get('uuid'),
                layer: $virtualMedia->get('layer'),
                globalStartTime: $virtualMedia->get('globalStartTime'),
                startTime: $virtualMedia->get('startTime'),
                duration: $virtualMedia->get('duration'),
                projectId: $virtualMedia->get('projectId'),
                mediaUuid: $virtualMedia->get('mediaUuid'),
                originalDuration: $virtualMedia->get('originalDuration'),
                position: new Position($virtualMedia->get('position')['x'], $virtualMedia->get('position')['y']),
                size: new Size($virtualMedia->get('size')['width'], $virtualMedia->get('size')['height'])
            );
        }

        return new CreateVirtualImageDto(
            uuid: $virtualMedia->get('uuid'),
            layer: $virtualMedia->get('layer'),
            globalStartTime: $virtualMedia->get('globalStartTime'),
            startTime: $virtualMedia->get('startTime'),
            duration: $virtualMedia->get('duration'),
            projectId: $virtualMedia->get('projectId'),
            mediaUuid: $virtualMedia->get('mediaUuid'),
            position: new Position($virtualMedia->get('position')['x'], $virtualMedia->get('position')['y']),
            size: new Size($virtualMedia->get('size')['width'], $virtualMedia->get('size')['height'])
        );
    }
}
