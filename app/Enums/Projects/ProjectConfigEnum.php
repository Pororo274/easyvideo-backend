<?php

namespace App\Enums\Projects;

use App\Dto\Projects\ProjectConfigDto;

enum ProjectConfigEnum: string
{
    case HORIZONTAL_360P = 'horizontal_360p';
    case VERTICAL_360P = 'vertical_360p';
    case HORIZONTAL_HD = 'horizontal_HD';
    case VERTICAL_HD = 'vertical_HD';

    public function toProjectConfigDto(): ProjectConfigDto
    {
        return match ($this) {
            static::HORIZONTAL_360P => new ProjectConfigDto(640, 360),
            static::VERTICAL_360P => new ProjectConfigDto(360, 640),
            static::HORIZONTAL_HD => new ProjectConfigDto(1280, 720),
            static::VERTICAL_HD => new ProjectConfigDto(720, 1280),
        };
    }

    static function getConfigs(): array
    {
        return [
            ['key' => static::HORIZONTAL_360P->value, 'text' => '640🞪360, 25fps'],
            ['key' => static::VERTICAL_360P->value, 'text' => '360🞪640, 25fps'],
            ['key' => static::HORIZONTAL_HD->value, 'text' => '1280🞪720, 25fps'],
            ['key' => static::VERTICAL_HD->value, 'text' => '720🞪1280, 25fps'],
        ];
    }
}
