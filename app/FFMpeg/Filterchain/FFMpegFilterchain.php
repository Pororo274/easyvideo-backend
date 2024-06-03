<?php

namespace App\FFMpeg\Filterchain;

use App\FFMpeg\Contracts\Executable;
use App\FFMpeg\Contracts\Maskable;
use App\FFMpeg\Filters\FFMpegFilter;
use Illuminate\Support\Str;

class FFMpegFilterchain implements Executable
{
    protected array $outputs = [];

    /**
     * @param Maskable[] $inputs
     * @param FFMpegFilter[] $filters
     */
    public function __construct(
        protected array $inputs,
        protected array $filters
    ) {
    }

    public function addOutputs(Maskable ...$outputs): self
    {
        $this->outputs = [...$this->outputs, ...$outputs];

        return $this;
    }

    public function getInputs(): array
    {
        return $this->inputs;
    }

    public function toRawCommand(): string
    {
        return collect($this->filters)->implode(function (FFMpegFilter $filter) {
            return $filter->toString();
        }, ',');
    }

    /**
     * @return Maskable[]
     */
    public function getOutputs(): array
    {
        return $this->outputs;
    }
}
