<?php

namespace App\Repositories;

use App\Contracts\Repositories\SubscriptionRepositoryContract;
use App\Dto\Subscription\CreateSubscriptionDto;
use App\Models\Subscription;

class SubscriptionRepository implements SubscriptionRepositoryContract
{
    public function store(CreateSubscriptionDto $dto): Subscription
    {
        return Subscription::query()->create([
            'user_id' => $dto->userId,
            'cost' => $dto->cost,
            'work_until' => $dto->workUntil
        ]);
    }
}
