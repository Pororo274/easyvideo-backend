<?php

namespace App\Jobs;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\MediaServiceContract;
use App\Contracts\Services\VirtualMediaServiceContract;
use App\Dto\Media\CreateMediaDto;
use App\Dto\Projects\ExportJobEndedDto;
use App\Dto\Projects\ProjectRenderJobDto;
use App\Dto\VirtualMedia\VirtualImageDto;
use App\Dto\VirtualMedia\WatermarkDto;
use App\Enums\Media\MediaTypeEnum;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\FFMpeg\Coordinate\Position;
use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Coordinate\Time;
use App\FFMpeg\Filters\FFMpegOverlayFilter;
use App\FFMpeg\Graph\FFMpegGraph;
use App\Helpers\FFMpegHelper;
use App\Notifications\ExportJobEndedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Symfony\Component\Uid\Uuid;

class ProjectRenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly ProjectRenderJobDto $dto
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(VirtualMediaServiceContract $virtualMediaService, UserRepositoryContract $userRepo, MediaServiceContract $mediaService): void
    {
        $virtualMedias = $virtualMediaService->findAllByProjectId($this->dto->projectId)->all();

        $graph = new FFMpegGraph();

        foreach ($virtualMedias as $dto) {
            $graph->addVirtualMedia($dto);
        }

        $graph->addVirtualMedia(new WatermarkDto(
            uuid: 'watermark',
            projectId: $this->dto->projectId,
            layer: -1,
            contentType: VirtualMediaTypeEnum::Image,
            content: "helpers/watermark.png",
            filters: [
                'position' => [
                    'x' => $this->dto->width - 76,
                    'y' => $this->dto->height - 76
                ],
                'size' => [
                    'width' => 64,
                    'height' => 64
                ],
            ]
        ));

        $output = "outputs/easyvideo_" . Str::random(10) . ".mp4";
        $graph
            ->addSize(new Size(
                width: $this->dto->width,
                height: $this->dto->height
            ))
            ->buildGraphPlan()
            ->execute($output);

        $mediaService->store(new CreateMediaDto(
            path: $output,
            projectId: $this->dto->projectId,
            isUploaded: true,
            mediaUuid: Uuid::v4(),
            originalName: '',
            type: MediaTypeEnum::EXPORT
        ));
        $user = $userRepo->findById($this->dto->userId);

        $user->notify(new ExportJobEndedNotification(
            new ExportJobEndedDto(
                userId: $this->dto->userId,
                projectId: $this->dto->projectId,
                link: url("/api/projects/download/" . basename($output))
            )
        ));
    }
}
