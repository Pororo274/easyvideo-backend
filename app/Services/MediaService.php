<?php

namespace App\Services;

use App\Console\Commands\CreateMedia;
use App\Contracts\Repositories\MediaRepositoryContract;
use App\Contracts\Services\MediaServiceContract;
use App\Dto\Media\CreateMediaDto;
use App\Dto\Media\SaveChunkDto;
use App\Models\Media;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MediaService implements MediaServiceContract
{
    public function __construct(
        protected MediaRepositoryContract $mediaRepo
    ) {
    }

    public function saveChunk(SaveChunkDto $dto): Media
    {
        $chunk = $dto->chunk;

        try {
            $this->mediaRepo->findByUuid($dto->mediaUuid);
        } catch (ModelNotFoundException $e) {
            $path = "media/" . $chunk->hashName();

            $media = $this->mediaRepo->store(new CreateMediaDto(
                path: $path,
                projectId: $dto->projectId,
                isUploaded: $dto->last,
                mediaUuid: $dto->mediaUuid,
                originalName: $dto->originalName
            ));
        }

        if ($dto->last) {
            $media = $this->mediaRepo->updateUploadStatusByUuid($dto->mediaUuid, true);
        }

        $absolutePath = Storage::disk('local')->path($media->path);
        File::append($absolutePath, $chunk->get());

        return $media;
    }
}
