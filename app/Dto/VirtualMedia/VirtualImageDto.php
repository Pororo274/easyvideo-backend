<?php

namespace App\Dto\VirtualMedia;

use App\Dto\TempMedia\TempImageDto;

readonly class VirtualImageDto extends VirtualMediaDto
{
    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration, public string $mediaPath)
    {
        parent::__construct($uuid, $layer, $globalStartTime, $startTime, $duration);
    }

    public function render(): TempImageDto
    {
        return new TempImageDto(
            mediaPath: $this->mediaPath,
            globalStartTime: $this->globalStartTime,
            duration: $this->duration,
            layer: $this->layer
        );
    }
}
