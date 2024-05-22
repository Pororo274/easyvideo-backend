<?php

namespace App\Factories\VirtualMedia;

use App\Dto\VirtualMedia\VirtualMediaDto;
use App\Models\VirtualMedia;

abstract readonly class VirtualMediaDtoFactory
{
    public function __construct(
        public VirtualMedia $virtualMedia
    ) {}

    public abstract function factoryMethod(): VirtualMediaDto;
}
