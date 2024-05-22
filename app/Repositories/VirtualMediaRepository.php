<?php

namespace App\Repositories;

use App\Contracts\Repositories\VirtualMediaRepositoryContract;
use App\Dto\VirtualMedia\CreateDto\CreateVirtualMediaDto;
use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualMediaDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Models\VirtualMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class VirtualMediaRepository implements VirtualMediaRepositoryContract
{

    public function store(CreateVirtualMediaDto $dto): VirtualMediaDto
    {
        return DB::transaction(function () use ($dto) {
            VirtualMedia::query()->create([
                'duration' => $dto->duration,
                'uuid' => $dto->uuid,
                'global_start_time' => $dto->globalStartTime,
                'project_id' => $dto->projectId,
                'start_time' => $dto->startTime,
                'layer' => $dto->layer,
                'type' => $dto->getType()
            ]);

            return $dto->store();
        });
    }

    public function findAllByProjectId(int $projectId): Collection
    {
        return VirtualMedia::query()->where('project_id', $projectId)->get();
    }

    public function update(UpdateVirtualMediaDto $dto): VirtualMediaDto
    {
        return DB::transaction(function () use ($dto) {
            VirtualMedia::query()->where('uuid', $dto->uuid)->update([
                'duration' => $dto->duration,
                'global_start_time' => $dto->globalStartTime,
                'start_time' => $dto->startTime,
                'layer' => $dto->layer,
            ]);

            return $dto->update();
        });
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
