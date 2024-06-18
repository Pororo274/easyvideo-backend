<?php

namespace App\Repositories;

use App\Contracts\Repositories\SubscriptionRepositoryContract;
use App\Dto\Subscription\CreateSubscriptionDto;
use App\Models\Subscription;
use Illuminate\Support\Carbon;

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

    public function acceptById(int $id): Subscription
    {
        Subscription::query()->where('id', $id)->update([
            'accepted_at' => Carbon::now()
        ]);

        return Subscription::query()->findOrFail($id);
    }

    public function findLastActiveByUserId(int $userId): Subscription
    {
        return Subscription::query()
                ->where('user_id', $userId)
                ->whereNotNull('accepted_at')
                ->orderByDesc('created_at')
                ->firstOrFail();
    }
}
