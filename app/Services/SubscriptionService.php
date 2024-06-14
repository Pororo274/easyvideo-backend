<?php

namespace App\Services;

use App\Contracts\Repositories\SubscriptionRepositoryContract;
use App\Contracts\Services\SubscriptionServiceContract;
use App\Dto\Subscription\CreateSubscriptionDto;
use App\Dto\Subscription\YookassaResponseDto;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SubscriptionService implements SubscriptionServiceContract
{
    public function __construct(
        protected SubscriptionRepositoryContract $subscriptionRepo
    ) {
    }

    public function store(CreateSubscriptionDto $dto): YookassaResponseDto
    {
        $subscription = $this->subscriptionRepo->store($dto);

        $response = Http::yookassa()->withHeaders([
            'Idempotence-Key' => Str::random()
        ])->post('/payments', [
            'amount' => [
                'value' => $dto->cost,
                'currency' => 'RUB'
            ],
            'capture' => true,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => 'https://test.com'
            ],
            'description' => 'Оформление подписки',
            'metadata' => [
                'sub_id' => $subscription->id
            ]
        ]);

        return new YookassaResponseDto(
            confirmationUrl: $response['confirmation']['confirmation_url']
        );
    }
}
