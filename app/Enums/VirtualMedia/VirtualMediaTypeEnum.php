<?php

namespace App\Enums\VirtualMedia;

use App\Factories\VirtualMedia\VirtualImageDtoFactory;
use App\Factories\VirtualMedia\VirtualMediaDtoFactory;
use App\Factories\VirtualMedia\VirtualVideoDtoFactory;
use App\Models\VirtualMedia;

enum VirtualMediaTypeEnum: string
{
    case VirtualVideo = 'virtual_video';
    case VirtualImage = 'virtual_image';

    public function getFactory(VirtualMedia $virtualMedia): VirtualMediaDtoFactory
    {
        return match ($this) {
            self::VirtualVideo => new VirtualVideoDtoFactory($virtualMedia),
            self::VirtualImage => new VirtualImageDtoFactory($virtualMedia)
        };
    }
}
