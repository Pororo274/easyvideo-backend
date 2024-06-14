<?php

namespace App\Contracts\Repositories;

use App\Dto\Subscription\CreateSubscriptionDto;
use App\Models\Subscription;

interface SubscriptionRepositoryContract
{
    public function store(CreateSubscriptionDto $dto): Subscription;
}
