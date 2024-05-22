<?php
namespace App\Dto\VirtualMedia;

use Illuminate\Support\Collection;

readonly class SyncVirtualMediaDto
{
    public function __construct(
        public int $projectId,
        public Collection $virtualMedias
    ) {}
}
