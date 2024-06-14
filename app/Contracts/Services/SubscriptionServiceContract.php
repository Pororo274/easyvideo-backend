<?php

namespace App\Contracts\Services;

use App\Dto\Subscription\CreateSubscriptionDto;
use App\Dto\Subscription\YookassaResponseDto;

interface SubscriptionServiceContract
{
    public function store(CreateSubscriptionDto $dto): YookassaResponseDto;
}
