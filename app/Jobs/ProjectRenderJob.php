<?php

namespace App\Jobs;

use App\Dto\Projects\ProjectRenderJobDto;
use App\Models\Media;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ProjectRenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const BLANK_PATH = "helpers/blank.jpg";

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly ProjectRenderJobDto $dto
    )
    {
        //
    }

    protected function mediaStep(): Collection
    {
        $nodes = $this->dto->nodes;
        $medias = Media::query()->where('project_id', $this->dto->projectId)->get();
        $mediaNodes = collect([]);

        foreach ($nodes as $node) {
            $startTime = $node['startTime'];
            $endTime = $node['endTime'];
            $mediaPath = $medias->where('id', $node['mediaId'])->first()->path;

            if ($node['mediaType'] !== 'mp4') {
                $mediaNodes->add([
                    'mediaId' => $node['mediaId'],
                    'nodeId' => $node['id'],
                    'path' => $mediaPath,
                    'duration' => $node['endTime'] - $node['startTime'],
                    'globalStartTime' => $node['globalStartTime'],
                ]);
                continue;
            }

            if ($startTime !== 0 || $endTime < $node['duration']) {

                $fileName = "media/node_".$node['id'].".mp4";

                FFMpeg::fromDisk('local')
                    ->open($mediaPath)
                    ->export()
                    ->toDisk('local')
                    ->addFilter('-ss', TimeCode::fromSeconds($startTime))
                    ->addFilter('-to', TimeCode::fromSeconds($endTime))
                    ->save($fileName);

                $mediaNodes->add([
                    'mediaId' => $node['mediaId'],
                    'nodeId' => $node['id'],
                    'path' => $fileName,
                    'duration' => $node['endTime'] - $node['startTime'],
                    'globalStartTime' => $node['globalStartTime'],
                ]);
            }
        }

        return $mediaNodes;
    }

    protected function buildStep(Collection $mediaNodes): void
    {
        //TODO: reduce by layer
        $groupedNodesByLayers = collect($this->dto->nodes)->groupBy('layer');

        $totalDuration = $groupedNodesByLayers->map(function (Collection $group) {
            return $group->reduce(function (float $carry, $node) {
                return $carry + ($node['endTime'] - $node['startTime']);
            }, 0);
        })->sort(function (float $duration, float $duration2) {
            if ($duration === $duration2) {
                return 0;
            }

            return $duration > $duration2 ? -1 : 1;
        })->first();

        //TODO: sort by globalStartTime
        $nodes = collect($this->dto->nodes)->sort(function ($node, $node2) {
            if ($node['layer'] === $node2['layer']) {
                return 0;
            }

            return $node['layer'] > $node2['layer'] ? -1 : 1;
        });

        $output = "media/blank  _0_".$this->dto->projectId.".mp4";

        $format = new X264();
        $format->setInitialParameters([
            "-f", "lavfi",
            "-i", "anullsrc",
            "-loop", "1",
        ]);

        //TODO: add resolution set
        FFMpeg::fromDisk('local')
            ->open(static::BLANK_PATH)
            ->addFilter('-t', $totalDuration)
            ->addFilter('-shortest')
            ->addFilter('-vf', 'scale=640:360,setdar=16/9')
            ->addFilter('-pix_fmt', 'yuv420p')
            ->export()
            ->inFormat($format)
            ->toDisk('local')
            ->save($output);


        foreach ($nodes as $node) {
            $mediaNode = $mediaNodes->where('nodeId', $node['id'])->first();

            $nextOutput = "media/easyvideo_".$node['id']."_".$this->dto->projectId.".mp4";

            FFMpeg::fromDisk('local')
                ->open([$output, $mediaNode['path']])
                ->addFilter(function (ComplexFilters $filters) use ($mediaNode, $node) {
                    if ($node['mediaType'] === 'mp4') {
                        $filters
                            ->custom('[1]', 'scale=640:-1,setpts=PTS-STARTPTS+'.$mediaNode['globalStartTime']."/TB", '[v1]')
                            ->custom('[0:v][v1]', 'overlay=0:0', '[v0]')
                            ->custom('[1:a]', 'adelay='. ($mediaNode['globalStartTime'] * 1000) .':all=1', '[a1]')
                            ->custom('[0:a][a1]', "amix=inputs=2", "[a2]");
                    } else {
                        $filters
                            ->custom('[0:v][1:v]', 'overlay=0:0', '[v0]')
                            ->custom('[0:a]', 'anull', '[a2]');
                    }

                })
                ->export()
                ->addFormatOutputMapping(new X264, \ProtoneMedia\LaravelFFMpeg\Filesystem\Media::make('local', $nextOutput), ['[v0]', '[a2]'])
                ->save();

            Storage::delete($output);
            $output = $nextOutput;
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mediaNodes = $this->mediaStep();
        $this->buildStep($mediaNodes);
    }
}
