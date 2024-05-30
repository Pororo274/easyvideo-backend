<?php

namespace App\Factories\VirtualMedia;

use App\Dto\Timeline\TimelineProperties;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Dto\VirtualMedia\VirtualVideoDto;
use App\Models\VirtualVideo;
use Illuminate\Database\Eloquent\Model;

class VirtualVideoDtoFactory extends VirtualMediaDtoFactory
{
    public function getModel(): string
    {
        return VirtualVideo::class;
    }

    public function getFields(): array
    {
        return ['original_duration', 'media_uuid'];
    }

    public function getRequired(): array
    {
        return ['originalDuration', 'mediaUuid'];
    }

    public function createVirtualMediaDtoFromModel(Model $vm): VirtualMediaDto
    {
        return new VirtualVideoDto(
            timelineProperties: new TimelineProperties($vm->uuid, $vm->layer, $vm->global_start_time, $vm->start_time, $vm->duration),
            filterList: $this->filterListFactory->factoryMethod($vm),
            originalDuration: $vm->original_duration,
            mediaUuid: $vm->media_uuid
        );
    }

    public function createVirtualMediaDtoFromArray(array $vm): VirtualMediaDto
    {
        return new VirtualVideoDto(
            timelineProperties: new TimelineProperties($vm['uuid'], $vm['layer'], $vm['globaStartTime'], $vm['startTime'], $vm['duration']),
            filterList: $this->filterListFactory->createFromArray($vm),
            originalDuration: $vm['originalDuration'],
            mediaUuid: $vm['mediaUuid']
        );
    }
}
