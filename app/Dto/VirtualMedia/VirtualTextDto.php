<?php

namespace App\Dto\VirtualMedia;

use App\FFMpeg\Coordinate\Size;
use App\FFMpeg\Filters\FFMpegScaleFilter;
use App\FFMpeg\Media\Inputs\FFMpegInput;
use App\FFMpeg\Media\Streams\FFMpegVideoStream;
use App\Models\Project;

readonly class VirtualTextDto extends VirtualMediaDto
{
    public function getFFMpegInput(): FFMpegInput
    {
        $project = Project::query()->where('id', $this->projectId)->first();

        return new FFMpegInput(
            path: "helpers/anaconda.png",
            streams: [new FFMpegVideoStream],
            beforeSplitFilters: [new FFMpegScaleFilter(
                new Size($project->width, $project->height)
            )]
        );
    }
}
