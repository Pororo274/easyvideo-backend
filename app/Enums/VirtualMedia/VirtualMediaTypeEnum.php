<?php

namespace App\Enums\VirtualMedia;

use App\Dto\VirtualMedia\VirtualImageDto;
use App\Dto\VirtualMedia\VirtualTextDto;
use App\Dto\VirtualMedia\VirtualVideoDto;

enum VirtualMediaTypeEnum: string
{
    case Video = 'video';
    case Audio = 'audio';
    case Image = 'image';
    case Custom = 'custom';
    case Text = 'text';

    public function toDtoClass(): string
    {
        return match ($this) {
            self::Video => VirtualVideoDto::class,
            self::Image => VirtualImageDto::class,
            self::Text => VirtualTextDto::class
        };
    }

    public function getTag(): string
    {
        return match ($this) {
            self::Video => 'videoFilterFactories',
            self::Image => 'imageFilterFactories',
            self::Audio => 'audioFilterFactories',
            self::Text => 'textFilterFactories',
        };
    }
}
