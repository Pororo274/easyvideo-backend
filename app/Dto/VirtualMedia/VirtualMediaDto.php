<?php

namespace App\Dto\VirtualMedia;

use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\FFMpeg\Factories\FilterList\FilterListFactory;
use App\FFMpeg\Filters\FFMpegFilterList;
use App\FFMpeg\Media\Inputs\FFMpegInput;
use Illuminate\Support\Facades\App;

readonly abstract class VirtualMediaDto
{
    protected FFMpegFilterList $filterList;


    public function __construct(
        public string $uuid,
        public int $projectId,
        public int $layer,
        public VirtualMediaTypeEnum $contentType,
        public string $content,
        public array $filters
    ) {
    }

    public function getFilterList(): FFMpegFilterList
    {
        return (new FilterListFactory(...App::tagged($this->contentType->getTag())))->createFromArray($this->filters);
    }

    public abstract function getFFMpegInput(): FFMpegInput;
}
