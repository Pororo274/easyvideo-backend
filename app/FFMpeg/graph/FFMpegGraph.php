<?php

namespace App\FFMpeg\graph;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\FFMpeg\Filterchain\FFMpegFilterchain;
use App\FFMpeg\Filters\FFMpegFilterList;
use App\FFMpeg\Media\Inputs\FFMpegInput;
use App\FFMpeg\Media\Streams\FFMpegStream;
use FFMpegGraphPlan;

class FFMpegGraph
{
    protected array $virtualMedias = [];
    protected FFMpegGraphPlan $graphPlan;
    protected array $filterchains = [];
    protected array $inputs = [];

    public function addVirtualMedia(VirtualMediaDto $vm): void {
        $this->virtualMedias  = [...$this->virtualMedias, $vm];
    }

    /**
     * @return void
     */

    public function buildGraphPlan(): void
    {
        $inputs = [];
        $filterchains = [];

        collect($this->virtualMedias)->each(function (VirtualMediaDto $vm) {
            global $inputs;
            global $filterchains;

            $input = $vm->getFFMpegInput();
            $inputs = [...$this->inputs, $input];
            $filterList = FFMpegFilterList::fromArrayToFilterList($vm->filters);

            $newFilterchains = collect($input->streams)->map(function (FFMpegStream $stream) use ($input, $filterList) {
                return new FFMpegFilterchain([$input], $filterList->getFiltersByStream($stream));
            });

            $filterchains = [...$this->filterchains, ...$newFilterchains->all()];
        });

        $clearedInputs = collect($inputs)->groupBy('path')->map(function (array $inputs, string $path) {
            global $filterchains;

            $newFilterchains = collect($inputs)->map(function (FFMpegInput $input) {
                collect($input->streams)->map(function (FFMpegStream $stream) use ($input) {
                    return new FFMpegFilterchain([$input], $filterList->getFiltersByStream($stream));
                });
            });
        });

        $this->graphPlan = new FFMpegGraphPlan(
            inputs: $clearedInputs,
            filterchains: $filterchains
        );
    }

    public function execute(string $output): string
    {
        return '';
    }
}
