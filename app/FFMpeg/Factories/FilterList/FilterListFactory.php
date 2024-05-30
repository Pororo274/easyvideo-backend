<?php

namespace App\FFMpeg\Factories\FilterList;

use App\FFMpeg\Factories\Filters\FFMpegFilterFactory;
use App\FFMpeg\Filters\FFMpegFilterList;

class FilterListFactory
{
    protected array $filterFactories;

    public function __construct(
        FFMpegFilterFactory ...$filterFactories
    ) {
        $this->filterFactories = $filterFactories;
    }

    public function factoryMethod(mixed $vm): FFMpegFilterList
    {
        $filterList = new FFMpegFilterList();

        foreach ($this->filterFactories as $factory) {
            $filter = $factory->createFilterFromModel($vm);

            $filterList->addFilter($filter);
        }

        return $filterList;
    }

    public function createFromArray(array $vm): FFMpegFilterList
    {
        $filterList = new FFMpegFilterList();

        foreach ($this->filterFactories as $factory) {
            $filter = $factory->createFromArray($vm);

            $filterList->addFilter($filter);
        }

        return $filterList;
    }
}
