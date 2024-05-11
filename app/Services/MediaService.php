<?php

namespace App\Services;

use App\Console\Commands\CreateMedia;
use App\Contracts\Repositories\MediaRepositoryContract;
use App\Contracts\Services\MediaServiceContract;
use App\Dto\Media\CreateMediaDto;
use App\Dto\Media\SaveChunkDto;
use App\Models\Media;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MediasService implements MediaServiceContract
{
    public function __construct(
        protected MediaRepositoryContract $mediaRepo
    ) {
    }

    public function saveChunk(SaveChunkDto $dto): Media
    {
        $chunk = $dto->chunk;

        if (is_null($dto->mediaId)) {
            $path = "media/" . $chunk->hashName();

            $media = $this->mediaRepo->store(new CreateMediaDto(
                path: $path,
                projectId: $dto->projectId
            ));
        } else {
            $media = $this->mediaRepo->findById($dto->mediaId);
            $path = $media->path;
        }

        $absolutePath = Storage::disk('local')->path($path);
        File::append($absolutePath, $chunk->get());

        return $media;
    }
}
