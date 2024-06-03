<?php

namespace App\Services;

use App\Contracts\Repositories\VirtualMediaRepositoryContract;
use App\Contracts\Services\VirtualMediaServiceContract;
use App\Dto\Media\CreateMediaDto;
use App\Dto\VirtualMedia\CreateDto\CreateVirtualMediaDto;
use App\Dto\VirtualMedia\SyncVirtualMediaDto;
use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualMediaDto;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\Models\VirtualMedia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class VirtualMediaService implements VirtualMediaServiceContract
{
    public function __construct(
        protected VirtualMediaRepositoryContract $virtualMediaRepo
    ) {
    }

    public function findAllByProjectId(int $projectId): Collection
    {
        return $this->virtualMediaRepo->findAllByProjectId($projectId)
            ->map(function (VirtualMedia $vm) {
                return $vm->toDto();
            });
    }

    public function sync(SyncVirtualMediaDto $dto): Collection
    {
        return collect($dto->virtualMedias)->map(function ($virtualMedia) use ($dto) {
            try {
                $this->virtualMediaRepo->findByUuid($virtualMedia['uuid']);
                return $this->virtualMediaRepo->update(new UpdateVirtualMediaDto(
                    uuid: $virtualMedia['uuid'],
                    layer: $virtualMedia['layer'],
                    contentType: VirtualMediaTypeEnum::from($virtualMedia['contentType']),
                    content: $virtualMedia['content'],
                    filters: $virtualMedia['filters'],
                ));
            } catch (ModelNotFoundException) {
                return $this->virtualMediaRepo->store(new CreateVirtualMediaDto(
                    uuid: $virtualMedia['uuid'],
                    projectId: $dto->projectId,
                    layer: $virtualMedia['layer'],
                    contentType: VirtualMediaTypeEnum::from($virtualMedia['contentType']),
                    content: $virtualMedia['content'],
                    filters: $virtualMedia['filters'],
                ))->toDto();
            }
        });
    }
}
