<?php

namespace App\Contracts\Services;

use App\Dto\VirtualMedia\CreateDto\CreateVirtualMediaDto;
use App\Dto\VirtualMedia\SyncVirtualMediaDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use Illuminate\Support\Collection;

interface VirtualMediaServiceContract
{
    /**
     * @param int $projectId
     * @return Collection<VirtualMediaDto>
     */
    public function findAllByProjectId(int $projectId): Collection;
    public function sync(SyncVirtualMediaDto $dto): Collection;
}
