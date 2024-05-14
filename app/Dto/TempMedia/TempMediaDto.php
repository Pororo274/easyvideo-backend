<?php

namespace App\Dto\TempMedia;

readonly abstract class TempMediaDto
{
    public function __construct(
        public string $mediaPath,
        public float $globalStartTime,
        public float $duration,
        public int $layer,
    ) {}

    public abstract function insertIntoBlankMedia(TempMediaDto $dto): TempMediaDto;
}
