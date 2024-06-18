<?php

namespace App\Dto\File;

use Illuminate\Support\Carbon;

readonly class FileDto
{
    public function __construct(
        public string $name,
        public string $directory,
        public int $sizeInBytes,
        public Carbon $modifiedDate,
        public string $mimeType,
        public string $url
    )
    {

    }
}
