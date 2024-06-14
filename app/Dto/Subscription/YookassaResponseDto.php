<?php

namespace App\Dto\Subscription;

readonly class YookassaResponseDto
{
    public function __construct(
        public string $confirmationUrl,
    ) {
    }
}
