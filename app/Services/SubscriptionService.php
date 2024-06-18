<?php

namespace App\Services;

use App\Contracts\Repositories\SubscriptionRepositoryContract;
use App\Contracts\Services\SubscriptionServiceContract;
use App\Dto\Subscription\CreateSubscriptionDto;
use App\Dto\Subscription\SubscriptionDto;
use App\Dto\Subscription\YookassaResponseDto;
use App\Dto\Subscription\YookassaWebhookDto;
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

    public function yookassaWebhook(YookassaWebhookDto $dto): void
    {
        if ($dto->event === 'payment.succeeded') {
            $this->subscriptionRepo->acceptById($dto->subscriptionId);
        }
    }

    public function findLastActiveByUserId(int $userId): SubscriptionDto
    {
        return $this->subscriptionRepo->findLastActiveByUserId($userId)->toDto();
    }
}
