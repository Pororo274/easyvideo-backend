<?php

namespace App\Enums\VirtualMedia;

use App\Dto\VirtualMedia\VirtualVideoDto;

enum VirtualMediaTypeEnum: string
{
    case Video = 'video';
    case Audio = 'audio';
    case Image = 'image';
    case Custom = 'custom';

    public function toDtoClass(): string
    {
        return match ($this) {
            self::Video => VirtualVideoDto::class
        };
    }

    public function getTag(): string
    {
        return match ($this) {
            self::Video => 'videoFilterFactories'
        };
    }
}
