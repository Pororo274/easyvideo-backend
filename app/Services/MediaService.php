<?php

namespace App\Services;

use App\Contracts\Repositories\MediaRepositoryContract;
use App\Contracts\Repositories\ProjectRepositoryContract;
use App\Contracts\Services\MediaServiceContract;
use App\Dto\File\FileDto;
use App\Dto\Media\CreateMediaDto;
use App\Dto\Media\MediaDto;
use App\Dto\Media\SaveChunkDto;
use App\Dto\Projects\UpdateProjectPreviewDto;
use App\Enums\Media\MediaTypeEnum;
use App\Helpers\FFMpegHelper;
use App\Helpers\MediaHelper;
use App\Models\Media;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService implements MediaServiceContract
{
    public function __construct(
        protected MediaRepositoryContract $mediaRepo,
        protected ProjectRepositoryContract $projectRepo
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
                    originalName: $dto->originalName,
                    type: MediaTypeEnum::ASSET
                ));
            }

            $absolutePath = Storage::disk('local')->path($media->path);
            File::append($absolutePath, $chunk->get());

//            if ($dto->last) {
//                $media = $this->mediaRepo->updateUploadStatusByUuid($dto->mediaUuid, true);
//                $framePath = "previews/" . Str::random() . ".jpg";
//                FFMpegHelper::saveFrameBySeconds($media->path, $framePath, 0);
//                $this->projectRepo->updatePreview(new UpdateProjectPreviewDto(
//                    projectId: $media->project_id,
//                    preview: $framePath
//                ));
//            }

            return $media;
        });

        return $media;
    }

    public function findAllByProjectId(int $projectId): Collection
    {
        return $this->mediaRepo->findAllByProjectId($projectId)->map(function (Media $media) {
            return $media->toDto();
        });
    }

    public function findOneByUuid(string $uuid): MediaDto
    {
        return $this->mediaRepo->findByUuid($uuid)->toDto();
    }

    public function store(CreateMediaDto $dto): MediaDto
    {
        return $this->mediaRepo->store($dto)->toDto();
    }

    public function getTotalSize(): float
    {
        $mediaFiles = Storage::files("media");
        $outputFiles = Storage::files("outputs");

        return collect([...$mediaFiles, ...$outputFiles])->reduce(function (float $carry, string $file) {
            return $carry + Storage::size($file);
        }, 0);
    }

    public function getFilesByDirectory(string $directory): Collection
    {
        return collect(Storage::files($directory))->map(function (string $path) use ($directory) {
            return new FileDto(
                name: basename($path),
                directory: $directory,
                sizeInBytes: Storage::size($path),
                modifiedDate: Carbon::createFromTimestamp(Storage::lastModified($path)),
                mimeType: Storage::mimeType($path),
                url: MediaHelper::getMediaUrl($path)
            );
        });
    }
}
