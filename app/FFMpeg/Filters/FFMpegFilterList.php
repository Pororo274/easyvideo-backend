<?php

namespace App\FFMpeg\Filters;

use App\FFMpeg\Contracts\AudioFilter;
use App\FFMpeg\Contracts\VideoFilter;
use App\FFMpeg\Media\Streams\FFMpegStream;
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

    public function getFiltersByStream(FFMpegStream $stream, array $except = []): array
    {
        return $this->filters->filter(function (FFMpegFilter $filter) use ($stream, $except) {
            $can = collect($except)->first(function (string $candidate) use ($filter) {
                return $filter instanceof ($candidate);
            });

            if ($can) {
                return false;
            }

            return $filter instanceof ($stream->getFilterType());
        })->all();
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
            return $filter->toArray();
        })->all();
    }

    public function toArray(): array
    {
        return $this->filters->all();
    }
}
