<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SubscriptionServiceContract;
use App\Dto\Subscription\CreateSubscriptionDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function createMonthSubscription(SubscriptionServiceContract $subscriptionService): JsonResponse
    {
        $response = $subscriptionService->store(new CreateSubscriptionDto(
            cost: 390,
            userId: Auth::id(),
            workUntil: Carbon::now()->addMonth()
        ));

        return response()->json($response);
    }
}
