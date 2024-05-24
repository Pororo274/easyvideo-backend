<?php

namespace App\Jobs;

use App\Dto\FFMpeg\CreateBlankVideoDto;
use App\Dto\Projects\ProjectRenderJobDto;
use App\Dto\Projects\RenderJobEndedDto;
use App\Dto\TempMedia\TempImageDto;
use App\Dto\TempMedia\TempMediaDto;
use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Events\RenderJobEndedEvent;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\Helpers\FFMpegHelper;
use App\Helpers\MediaHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Reverb\Loggers\Log;

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
        return $this->dto->virtualMedias->map(function (VirtualMediaDto $virtualMedia) {
            return $virtualMedia->createTempMedia();
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
        $sortedTempMedias = $sortedTempMedias->add(new TempImageDto(
            mediaPath: "helpers/watermark.png",
            globalStartTime: 0,
            duration: $totalDuration,
            layer: 1,
            size: new Size(64, 64),
            position: new Position($this->dto->width - 64, $this->dto->height - 64)
        ));

        $output = "temp-media/blank  _0_" . $this->dto->projectId . ".mp4";

        $blankVideo = FFMpegHelper::createBlankVideo(new CreateBlankVideoDto(
            outputPath: $output,
            width: $this->dto->width,
            height: $this->dto->height,
            duration: $totalDuration,
        ));

        \Illuminate\Support\Facades\Log::debug($sortedTempMedias);

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
        $tempMedias = $this->mediaStep();
        $output = $this->mergeStep($tempMedias);
        \Illuminate\Support\Facades\Log::debug('Rendered');
        RenderJobEndedEvent::dispatch(new RenderJobEndedDto(
            userId: $this->dto->userId,
            projectId: $this->dto->projectId,
            link: url("/api/projects/download/".basename($output))
        ));

        MediaHelper::removeTempMedias($tempMedias);
    }
}
