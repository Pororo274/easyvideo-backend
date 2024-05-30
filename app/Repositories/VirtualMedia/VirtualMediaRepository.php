<?php

namespace App\Repositories\VirtualMedia;

use App\Contracts\Repositories\VirtualMediaRepositoryContract;
use App\Dto\VirtualMedia\UpdateDto\UpdateVirtualMediaDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Factories\VirtualMedia\VirtualMediaDtoFactory;
use App\Helpers\VirtualMediaHelper;
use App\Models\VirtualMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class VirtualMediaRepository implements VirtualMediaRepositoryContract
{
    private Model $modelInstance;
    private array $fields;
    private array $factories;

    public function __construct(
        VirtualMediaDtoFactory ...$factories
    ) {
        $this->factories = $factories;
    }

    private function setInstance(string $model, array $fields): void
    {
        $this->modelInstance = App::make($model);
        $this->fields = $fields;
    }

    public function store(array $vm, int $projectId): VirtualMediaDto
    {
        foreach ($this->factories as $factory) {
            if (!collect($vm)->has($factory->getRequired())) continue;

            /**
             * @var VirtualMediaDto $dto
             */
            $dto = $factory->createVirtualMediaDtoFromArray($vm);
            $this->setInstance($factory->getModel(), $factory->getFields());

            DB::transaction(function () use ($dto, $projectId) {
                VirtualMedia::query()->create([
                    'duration' => $dto->timelineProperties->duration,
                    'uuid' => $dto->timelineProperties->uuid,
                    'global_start_time' => $dto->timelineProperties->globalStartTime,
                    'project_id' => $projectId,
                    'start_time' => $dto->timelineProperties->startTime,
                    'layer' => $dto->timelineProperties->layer,
                    'type' => ''
                ]);

                $this->modelInstance::query()->create([
                    'uuid' => $dto->timelineProperties->uuid,
                    ...$dto->toArray()
                ]);
            });

            return $dto;
        }
    }

    public function findAllByProjectId(int $projectId): Collection
    {
        $virtualMedias = [];

        foreach ($this->factories as $factory) {
            $this->setInstance($factory->getModel(), $factory->getFields());

            $tempVirtualMedias = $this->modelInstance::query()
                ->where('project_id', $projectId)
                ->join('virtual_media', 'virtual_media.uuid', '=', 'virtual_videos.uuid')
                ->get([...VirtualMediaHelper::TIMELINE_PROPERTIES, ...VirtualMediaHelper::DIMENSIONS, ...$this->fields])
                ->map(function ($vm) use ($factory) {
                    return $factory->createVirtualMediaDtoFromModel($vm);
                })->all();

            $virtualMedias = [...$virtualMedias, ...$tempVirtualMedias];
        }

        return collect($virtualMedias);
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
