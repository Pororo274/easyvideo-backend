<?php

namespace App\Jobs;

use App\Dto\FFMpeg\CreateBlankVideoDto;
use App\Dto\Projects\ProjectRenderJobDto;
use App\Dto\Projects\RenderJobEndedDto;
use App\Dto\TempMedia\TempMediaDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Events\RenderJobEndedEvent;
use App\Helpers\FFMpegHelper;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
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

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly ProjectRenderJobDto $dto
    ) {
        //
    }

    /**
     * @return Collection<TempMediaDto>
     */
    protected function mediaStep(): Collection
    {
        return collect($this->dto->virtualMedias)->map(function (VirtualMediaDto $virtualMedia) {
            return $virtualMedia->render();
        });
    }

    /**
     * @param Collection<TempMediaDto> $tempMedias
     * @return string
     */
    protected function mergeStep(Collection $tempMedias): string
    {
        $totalDuration = $tempMedias->map(function (TempMediaDto $dto) {
            return $dto->globalStartTime + $dto->duration;
        })->sort(function (float $duration1, float $duration2) {
            if ($duration1 === $duration2) {
                return 0;
            }

            return $duration1 > $duration2 ? -1 : 1;
        })->first();

        $sortedTempMedias = $tempMedias->sortByDesc('layer');

        $output = "temp-media/blank  _0_" . $this->dto->projectId . ".mp4";

        $blankVideo = FFMpegHelper::createBlankVideo(new CreateBlankVideoDto(
            outputPath: $output,
            width: $this->dto->width,
            height: $this->dto->height,
            duration: $totalDuration,
        ));

        /**
         * @var TempMediaDto[] $sortedTempMediasArray
         */
        $sortedTempMediasArray = $sortedTempMedias->toArray();

        foreach ($sortedTempMediasArray as $tempMedia) {
            $blankVideo = $tempMedia->insertIntoBlankMedia($blankVideo);
        }

        return $blankVideo->mediaPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mediaNodes = $this->mediaStep();
        $output = $this->mergeStep($mediaNodes);
        RenderJobEndedEvent::dispatch(new RenderJobEndedDto(
            userId: $this->dto->userId,
            projectId: $this->dto->projectId,
            link: url("/api/projects/download/".basename($output))
        ));
    }
}
