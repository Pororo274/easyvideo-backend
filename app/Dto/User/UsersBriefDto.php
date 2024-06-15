<?php

namespace App\Dto\User;

readonly class UsersBriefDto
{
    public function __construct(
        public int $total,
        public int $totalWithSubscription,
        public int $totalBanned
    ) {
    }
}
