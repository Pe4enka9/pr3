<?php

namespace App\Http\Controllers\Auth;

use App\Dtos\Auth\RegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function registerForm(): View
    {
        $genders = Gender::all();

        return view('auth.register', ['genders' => $genders]);
    }

    public function register(RegisterDto $dto): JsonResponse
    {
        $user = User::query()->create([
            'name' => $dto->name,
            'last_name' => $dto->lastName,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'gender_id' => $dto->gender,
            'password' => Hash::make($dto->password),
        ]);

        return response()->json(new UserResource($user), 201);
    }
}
