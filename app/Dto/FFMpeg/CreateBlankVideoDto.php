<?php

namespace App\Dto\FFMpeg;

readonly class CreateBlankVideoDto
{
    public function __construct(
        public string $outputPath,
        public int $width,
        public int $height,
        public float $duration
    ) {}
}
