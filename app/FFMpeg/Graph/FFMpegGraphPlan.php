<?php

namespace App\FFMpeg\Graph;

class FFMpegGraphPlan
{
    protected string $output;

    public function __construct(
        protected array $inputs,
        protected array $filterchains,
    ) {
    }

    public function setOutput(string $output): void
    {
        $this->output = $output;
    }

    public function getInputs(): array
    {
        return $this->inputs;
    }

    public function getFilterchains(): array
    {
        return $this->filterchains;
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}
