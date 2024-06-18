<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SubscriptionServiceContract;
use App\Dto\Subscription\CreateSubscriptionDto;
use App\Dto\Subscription\YookassaWebhookDto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;

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

    public function yookassaWebhook(Request $request, SubscriptionServiceContract $subscriptionService): JsonResponse
    {
        $subscriptionService->yookassaWebhook(new YookassaWebhookDto(
            event: $request->input('event'),
            subscriptionId: collect($request->input('object'))->get('metadata')['sub_id']
        ));

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function findLast(int $userId, SubscriptionServiceContract $subscriptionService): JsonResponse
    {
        try {
            $sub = $subscriptionService->findLastActiveByUserId($userId);
        } catch (ModelNotFoundException) {
            return response()->json();
        }

        return response()->json($sub);
    }
}
