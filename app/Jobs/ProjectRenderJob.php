<?php

namespace App\Jobs;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\MediaServiceContract;
use App\Contracts\Services\VirtualMediaServiceContract;
use App\Dto\Media\CreateMediaDto;
use App\Dto\Projects\ExportJobEndedDto;
use App\Dto\Projects\ProjectRenderJobDto;
use App\Enums\Media\MediaTypeEnum;
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
use Symfony\Component\Uid\Uuid;

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
     * Execute the job.
     */
    public function handle(VirtualMediaServiceContract $virtualMediaService, UserRepositoryContract $userRepo, MediaServiceContract $mediaService): void
    {
        $virtualMedias = $virtualMediaService->findAllByProjectId($this->dto->projectId)->all();

        $graph = new FFMpegGraph();

        foreach ($virtualMedias as $dto) {
            $graph->addVirtualMedia($dto);
        }


        $output = "outputs/easyvideo_" . Str::random(10) . ".mp4";
        $graph
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
