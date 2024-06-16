<?php

namespace App\FFMpeg\Graph;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\FFMpeg\Contracts\Maskable;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Factories\Filters\FFMpegOverlayFilterFactory;
use App\FFMpeg\Factories\Filters\FFMpegScaleFilterFactory;
use App\FFMpeg\Filterchain\FFMpegFilterchain;
use App\FFMpeg\Filters\FFMpegASplitFilter;
use App\FFMpeg\Filters\FFMpegOverlayFilter;
use App\FFMpeg\Filters\FFMpegScaleFilter;
use App\FFMpeg\Filters\FFMpegSetdarFilter;
use App\FFMpeg\Filters\FFMpegSplitFilter;
use App\FFMpeg\Graph\FFMpegGraphPlan;
use App\FFMpeg\Media\Inputs\FFMpegInput;
use App\FFMpeg\Media\Inputs\FFMpegMask;
use App\FFMpeg\Media\Streams\FFMpegAudioStream;
use App\FFMpeg\Media\Streams\FFMpegStream;
use App\FFMpeg\Media\Streams\FFMpegVideoStream;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class FFMpegGraph
{
    protected array $virtualMedias = [];
    protected FFMpegGraphPlan $graphPlan;
    protected array $filterchains = [];
    protected array $inputs = [];
    protected FFMpegInput $blank;
    protected Maskable $lastVideoOutput;
    protected Maskable $lastAudioOutput;

    public function __construct()
    {
        $this->blank = new FFMpegInput(
            "helpers/blank.jpg",
            [new FFMpegVideoStream]
        );

        $this->lastVideoOutput = $this->blank->streams[0];
    }

    public function addVirtualMedia(VirtualMediaDto $vm): void
    {
        $this->virtualMedias  = [...$this->virtualMedias, $vm];
    }

    /**
     * @return self
     */

    public function buildGraphPlan(): self
    {
        $inputs = [];

        $sortedVirtualMedias = collect($this->virtualMedias)->sortByDesc('layer');
        $blankFilterchain = (new FFMpegFilterchain([$this->lastVideoOutput], [
            new FFMpegScaleFilter(
                new Size(640, 360),
            ),
            new FFMpegSetdarFilter(
                new Size(640, 360),
            )
        ]));
        $this->lastVideoOutput = new FFMpegVideoStream;
        $blankFilterchain->addOutputs($this->lastVideoOutput);

        $filterchains = [$blankFilterchain];

        $filterchains = [...$filterchains, ...$sortedVirtualMedias->map(function (VirtualMediaDto $vm) use (&$inputs) {
            $filterList = $vm->getFilterList();
            $input = $vm->getFFMpegInput();
            $inputs = collect($inputs)->add($input);

            $filterchains = collect($input->streams)->map(function (FFMpegStream $stream) use ($filterList, $vm) {
                $chain = new FFMpegFilterchain([$stream], $filterList->getFiltersByStream($stream, [FFMpegOverlayFilter::class]));
                $newStream = $stream->createStream();
                $chain->addOutputs($newStream);

                if ($stream->getMask() === 'v') {
                    $mergeFilterchain = new FFMpegFilterchain([$this->lastVideoOutput, $newStream], [
                        (new FFMpegOverlayFilterFactory)->createFilterFromArray($vm->filters)
                    ]);

                    $outputStream = $newStream->createStream();
                    $mergeFilterchain->addOutputs($outputStream);

                    $this->lastVideoOutput = $outputStream;

                    return [$chain, $mergeFilterchain];
                } else {
                    $this->lastAudioOutput = $newStream;
                }

                return [$chain];
            })->flatten();

            return $filterchains;
        })->flatten()->all()];

        $inputs = collect($inputs)->add($this->blank)->all();

        $groupedByPath = collect($inputs)->groupBy('path');
        $paths = $groupedByPath->map(function (Collection $inputs, string $path) {
            return $path;
        });

        $paths = $paths->values();

        $inputFilterchains = $paths->map(function (string $path, int $key) use ($groupedByPath) {
            $inputs = $groupedByPath->get($path, collect());

            $beforeSplitFilters = $inputs->get(0)->beforeSplitFilters;

            $streams = $inputs->map(function (FFMpegInput $input) {
                return $input->streams;
            })->flatten()->all();

            $filterchains = collect($streams)->groupBy(function (FFMpegStream $stream) {
                return $stream->getMask();
            })->map(function (Collection $streams, string $mask) use ($key, $beforeSplitFilters) {
                $splitFilter = $mask === 'v' ? new FFMpegSplitFilter($streams->count()) : new FFMpegASplitFilter($streams->count());

                $filterchain = (new FFMpegFilterchain([new FFMpegMask('[' . $key . ':' . $mask . ']')], [
                    ...$beforeSplitFilters,
                    $splitFilter
                ]))->addOutputs(...$streams);
                return $filterchain;
            });
            return $filterchains;
        })->flatten()->all();

        $this->graphPlan = new FFMpegGraphPlan(
            inputs: $paths->all(),
            filterchains: [...$inputFilterchains, ...$filterchains]
        );

        return $this;
    }

    public function execute(string $output): string
    {
        $plan = $this->graphPlan;

        FFMpeg::fromDisk('local')
            ->open($plan->getInputs())
            ->addFilter(function (ComplexFilters $filters) use ($plan) {
                foreach ($plan->getFilterchains() as $chain) {
                    $inputs = collect($chain->getInputs())->implode(function (Maskable $mask) {
                        return $mask->toRawMask();
                    }, '');

                    $outputs = collect($chain->getOutputs())->implode(function (Maskable $mask) {
                        return $mask->toRawMask();
                    }, '');

                    $filters->custom($inputs, $chain->toRawCommand(), $outputs);
                }
            })
            ->export()
            ->addFormatOutputMapping(new X264, \ProtoneMedia\LaravelFFMpeg\Filesystem\Media::make('local', $output), [$this->lastVideoOutput->toRawMask(), $this->lastAudioOutput->toRawMask()])
            ->save();


        return '';
    }
}
