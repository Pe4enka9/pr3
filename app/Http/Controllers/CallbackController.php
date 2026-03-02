<?php

namespace App\Http\Controllers;

use App\Dtos\CallbackDto;
use App\Http\Resources\CallbackResource;
use App\Models\Callback;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CallbackController extends Controller
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
}
