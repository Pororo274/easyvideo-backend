<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;
use Illuminate\Support\Facades\Log;

class FFMpegFlipFilter extends FFMpegFilter implements VideoFilter
{
    public function __construct(
        protected bool $h,
        protected bool $v
    )
    {
    }

    public function toArray(): array
    {
        return [
            'h' => $this->h,
            'v' => $this->v
        ];
    }

    public function toString(): string
    {
        $command = '';

        if ($this->h) {
            $command .= 'hflip';
        }

        if ($this->h && $this->v) {
            $command .= ',';
        }

        if ($this->v) {
            $command .= 'vflip';
        }

        return $command;
    }
}
