<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Filters\FFMpegFilter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $path = "C\\\\:/Windows/fonts/consola.ttf";

        return "drawtext=fontfile=".$path . ":text='" . $this->text . "':fontsize=" . $this->fontSize . ":fontcolor=white";
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
