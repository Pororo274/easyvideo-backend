<?php

namespace App\Dto\Media;

use Illuminate\Http\UploadedFile;

readonly class SaveChunkDto
{
    public function __construct(
        public UploadedFile $chunk,
        public int $projectId,
        public bool $last,
        public string $mediaUuid,
        public string $originalName
    ) {
    }
}
