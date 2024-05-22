<?php

namespace App\Services;

use App\Console\Commands\CreateMedia;
use App\Contracts\Repositories\MediaRepositoryContract;
use App\Contracts\Services\MediaServiceContract;
use App\Dto\Media\CreateMediaDto;
use App\Dto\Media\SaveChunkDto;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
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

        $media = DB::transaction(function () use ($dto, $chunk) {
            try {
                $media = $this->mediaRepo->findByUuid($dto->mediaUuid);
            } catch (ModelNotFoundException) {
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
        });

        return $media;
    }

    public function findAllByProjectId(int $projectId): Collection
    {
        return $this->mediaRepo->findAllByProjectId($projectId);
    }

    public function findOneByUuid(string $uuid): Media
    {
        return $this->mediaRepo->findByUuid($uuid);
    }
}
