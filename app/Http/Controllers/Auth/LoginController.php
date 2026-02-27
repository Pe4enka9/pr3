<?php

namespace App\Http\Controllers\Auth;

use App\Dtos\Auth\LoginDto;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function loginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginDto $dto): JsonResponse
    {
        $user = Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password,
        ], $dto->remember);

        if (!$user) {
            return response()->json(['success' => false], 404);
        }

        return response()->json(['success' => true]);
    }
}
