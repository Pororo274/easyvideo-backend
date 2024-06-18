<?php

namespace App\Dto\Subscription;

readonly class YookassaWebhookDto
{
    public function __construct(
        public string $event,
        public int $subscriptionId
    )
    {
    }
}
