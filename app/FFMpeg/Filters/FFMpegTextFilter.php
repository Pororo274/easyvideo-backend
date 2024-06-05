<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Filters\FFMpegFilter;

class FFMpegTextFilter extends FFMpegFilter implements VideoFilter
{
    public function __construct(
        protected float $fontSize,
        protected string $text
    ) {
        $this->name = 'ScaleFilter';
    }

    public function toString(): string
    {
        return '';
    }

    public function toArray(): array
    {
        return [
            'text' => [
                'fontSize' => $this->fontSize,
                'text' => $this->text
            ]
        ];
    }
}
