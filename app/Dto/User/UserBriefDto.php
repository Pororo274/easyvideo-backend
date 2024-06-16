<?php

namespace App\Dto\User;

readonly class UserBriefDto
{
    public function __construct(
        public int $totalUsedSpaceInBytes,
        public int $totalAvailableSpaceInBytes
    )
    {
    }
}
