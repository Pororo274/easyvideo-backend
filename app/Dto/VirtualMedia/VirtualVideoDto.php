<?php

namespace App\Dto\VirtualMedia;

use App\Dto\TempMedia\TempVideoDto;
use FFMpeg\Coordinate\TimeCode;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

readonly class VirtualVideoDto extends VirtualMediaDto
{
    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration, public string $mediaPath, public float $originalDuration)
    {
        parent::__construct($uuid, $layer, $globalStartTime, $startTime, $duration);
    }

    public function render(): TempVideoDto
    {
        if ($this->duration !== $this->originalDuration || !$this->startTime) {
            $outputFilePath = "temp-media/tmp_" . $this->uuid.".mp4";
            FFMpeg::fromDisk('local')
                ->open($this->mediaPath)
                ->export()
                ->toDisk('local')
                ->addFilter('-ss', TimeCode::fromSeconds($this->startTime))
                ->addFilter('-to', TimeCode::fromSeconds($this->getEndTime()))
                ->save($outputFilePath);

            return new TempVideoDto(
                mediaPath: $outputFilePath,
                globalStartTime: $this->globalStartTime,
                duration: $this->duration,
                layer: $this->layer
            );
        }

        return new TempVideoDto(
            mediaPath: $this->mediaPath,
            globalStartTime: $this->globalStartTime,
            duration: $this->duration,
            layer: $this->layer
        );
    }
}
