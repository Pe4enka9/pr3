<?php

namespace App\Http\Controllers;

use App\Dtos\CallbackDto;
use App\Dtos\OnlineOrderDto;
use App\Http\Resources\CallbackResource;
use App\Http\Resources\OrderResource;
use App\Models\Callback;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MainContorller extends Controller
{
    public function callbackForm(): View
    {
        return view('callback');
    }

    public function callback(CallbackDto $dto): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $callback = Callback::query()->create([
            'user_id' => $user->id,
            'name' => $dto->name,
            'phone' => $dto->phone,
            'time' => $dto->time,
        ]);

        return response()->json(new CallbackResource($callback), 201);
    }

    public function onlineOrderForm(): View
    {
        return view('online-order');
    }

    public function onlineOrder(OnlineOrderDto $dto): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $order = Order::query()->create([
            'user_id' => $user->id,
            'name' => $dto->name,
            'phone' => $dto->phone,
            'email' => $dto->email,
            'address' => $dto->address,
            'comment' => $dto->message,
        ]);

        return response()->json(new OrderResource($order), 201);
    }
}
