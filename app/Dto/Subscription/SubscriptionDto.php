<?php

namespace App\Dto\Subscription;

use Illuminate\Support\Carbon;

readonly class SubscriptionDto
{
    public function __construct(
        public int $id,
        public int $userId,
        public Carbon $workUntil
    ) {}
}
