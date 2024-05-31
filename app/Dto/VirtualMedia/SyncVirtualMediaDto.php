<?php

namespace App\Dto\VirtualMedia;

readonly class SyncVirtualMediaDto
{
    public function __construct(
        public int $projectId,
        public array $virtualMedias
    ) {
    }
}
