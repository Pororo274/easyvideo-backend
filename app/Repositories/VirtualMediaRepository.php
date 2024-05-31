<?php

namespace App\Repositories;

use App\Contracts\Repositories\VirtualMediaRepositoryContract;
use App\Dto\VirtualMedia\CreateDto\CreateVirtualMediaDto;
use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualMediaDto;
use App\Models\VirtualMedia;
use Illuminate\Database\Eloquent\Collection;

class VirtualMediaRepository implements VirtualMediaRepositoryContract
{
    public function store(CreateVirtualMediaDto $dto): VirtualMedia
    {
        return VirtualMedia::query()->create([
            'uuid' => $dto->uuid,
            'project_id' => $dto->projectId,
            'layer' => $dto->layer,
            'content_type' => $dto->contentType,
            'content' => $dto->content,
            'filters' => $dto->filters,
        ]);
    }

    public function findAllByProjectId(int $projectId): Collection
    {
        return VirtualMedia::query()->where('project_id', $projectId)->get();
    }

    public function update(UpdateVirtualMediaDto $dto): VirtualMedia
    {
        VirtualMedia::query()->where('uuid', $dto->uuid)->update([
            'content' => $dto->content,
            'filters' => $dto->filters,
            'layer' => $dto->layer,
        ]);

        return $this->findByUuid($dto->uuid);
    }

    public function deleteByUuid(string $uuid): void
    {
        VirtualMedia::query()->where('uuid', $uuid)->delete();
    }

    public function findByUuid(string $uuid): VirtualMedia
    {
        return VirtualMedia::query()->where('uuid', $uuid)->firstOrFail();
    }
}
