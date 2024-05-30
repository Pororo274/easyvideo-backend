<?php

namespace App\Services;

use App\Contracts\Repositories\VirtualMediaRepositoryContract;
use App\Contracts\Services\VirtualMediaServiceContract;
use App\Dto\VirtualMedia\SyncVirtualMediaDto;
use App\Factories\VirtualMedia\VirtualMediaDtoFactory;
use App\Helpers\VirtualMediaHelper;
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
        return $this->virtualMediaRepo->findAllByProjectId($projectId);
    }

    public function sync(SyncVirtualMediaDto $dto): Collection
    {
        return $dto->virtualMedias->map(function ($virtualMedia) use ($dto) {
            try {
                $this->virtualMediaRepo->findByUuid($virtualMedia['uuid']);

                $updateDto = VirtualMediaHelper::getUpdateDtoFromCollection(collect($virtualMedia));
                return $this->virtualMediaRepo->update($updateDto);
            } catch (ModelNotFoundException) {
                $createDto = VirtualMediaHelper::getCreateDtoFromCollection(collect([...$virtualMedia, 'projectId' => $dto->projectId]));
                return $this->virtualMediaRepo->store($createDto);
            }
        });
    }
}
