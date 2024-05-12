<?php

namespace App\Enums\Media;

enum MediaStatusEnum: string
{
    case UPLOADED = 'uploaded';
    case NOT_UPLOADED = 'notUploaded';

    static function fromBool(bool $value): self
    {
        return match ($value) {
            true => static::UPLOADED,
            false => static::NOT_UPLOADED
        };
    }
}
