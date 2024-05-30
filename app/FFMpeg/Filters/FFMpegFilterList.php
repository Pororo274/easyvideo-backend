<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\AudioFilter;
use App\FFMpeg\Contracts\VideoFilter;
use Illuminate\Support\Collection;

class FFMpegFilterList
{
    protected Collection $filters;

    public function __construct()
    {
        $this->filters = collect([]);
    }


    public function addFilter(FFMpegFilter $filter): void
    {
        $this->filters->add($filter);
    }

    public function getAudioFilters(): Collection
    {
        return $this->filters->filter(function (FFMpegFilter $filter) {
            return $filter instanceof AudioFilter;
        });
    }

    public function getVideoFilters(): Collection
    {
        return $this->filters->filter(function (FFMpegFilter $filter) {
            return $filter instanceof VideoFilter;
        });
    }

    public static function fromArrayToFilterList(array $filters): FFMpegFilterList
    {
        $filterList = new FFMpegFilterList();

        foreach ($filters as $filter) {
            $filterList->addFilter($filter);
        }

        return $filterList;
    }

    public function toKeyedArray(): array
    {
        return $this->filters->mapWithKeys(function (FFMpegFilter $filter) {
            return [
                $filter->getName() => $filter
            ];
        })->all();
    }

    public function toArray(): array
    {
        return $this->filters->all();
    }
}
