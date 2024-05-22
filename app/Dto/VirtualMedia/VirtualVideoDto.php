<?php

namespace App\Dto\VirtualMedia;

use App\Contracts\Repositories\MediaRepositoryContract;
use App\Dto\TempMedia\TempVideoDto;
use App\Models\Media;
use FFMpeg\Coordinate\TimeCode;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

readonly class VirtualVideoDto extends VirtualMediaDto
{
    public function __construct(string $uuid, int $layer, float $globalStartTime, float $startTime, float $duration, public string $mediaUuid, public float $originalDuration)
    {
        parent::__construct($uuid, $layer, $globalStartTime, $startTime, $duration);
    }

    public function createTempMedia(): TempVideoDto
    {
        $media = Media::query()->where('uuid', $this->mediaUuid)->first();

        if ($this->duration !== $this->originalDuration || !$this->startTime) {
            $outputFilePath = "temp-media/tmp_" . $this->uuid.".mp4";
            FFMpeg::fromDisk('local')
                ->open($media->path)
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
            mediaPath: $media->path,
            globalStartTime: $this->globalStartTime,
            duration: $this->duration,
            layer: $this->layer
        );
    }
}
