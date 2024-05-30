<?php

namespace App\Factories\VirtualMedia;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\FFMpeg\Factories\FilterList\FilterListFactory;
use Illuminate\Database\Eloquent\Model;

abstract class VirtualMediaDtoFactory
{
    public function __construct(
        protected FilterListFactory $filterListFactory
    ) {
    }
    public abstract function getModel(): string;
    public abstract function getFields(): array;
    public abstract function getRequired(): array;

    public abstract function createVirtualMediaDtoFromModel(Model $vm): VirtualMediaDto;
    public abstract function createVirtualMediaDtoFromArray(array $vm): VirtualMediaDto;
}
