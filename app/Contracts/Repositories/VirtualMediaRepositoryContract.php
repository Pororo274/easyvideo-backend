<?php

namespace App\Contracts\Repositories;

use App\Dto\VirtualMedia\CreateDto\CreateVirtualMediaDto;
use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualMediaDto;
use App\Models\VirtualMedia;
use Illuminate\Database\Eloquent\Collection;

interface VirtualMediaRepositoryContract
{
    public function store(CreateVirtualMediaDto $dt): VirtualMedia;
    public function findAllByProjectId(int $projectId): Collection;
    public function update(UpdateVirtualMediaDto $dto): VirtualMedia;
    public function deleteByUuid(string $uuid): void;
    public function findByUuid(string $uuid): VirtualMedia;
}
