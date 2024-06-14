<?php

namespace App\Dto\Subscription;

use Illuminate\Support\Carbon;

readonly class CreateSubscriptionDto
{
    public function __construct(
        public float $cost,
        public int $userId,
        public Carbon $workUntil,
    ) {
    }
}
