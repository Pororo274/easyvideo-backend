<?php

namespace App\Contracts\Services;

use App\Dto\Subscription\CreateSubscriptionDto;
use App\Dto\Subscription\SubscriptionDto;
use App\Dto\Subscription\YookassaResponseDto;
use App\Dto\Subscription\YookassaWebhookDto;

interface SubscriptionServiceContract
{
    public function store(CreateSubscriptionDto $dto): YookassaResponseDto;
    public function yookassaWebhook(YookassaWebhookDto $dto): void;
    public function findLastActiveByUserId(int $userId): SubscriptionDto;
}
