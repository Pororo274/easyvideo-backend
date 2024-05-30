<?php

namespace App\Contracts\Repositories;

use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualMediaDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Models\VirtualMedia;
use Illuminate\Support\Collection;

interface VirtualMediaRepositoryContract
{
    public function store(array $vm, int $projectId): VirtualMediaDto;
    public function findAllByProjectId(int $projectId): Collection;
    public function update(UpdateVirtualMediaDto $dto): VirtualMediaDto;
    public function deleteByUuid(string $uuid): void;
    public function findByUuid(string $uuid): VirtualMedia;
}
