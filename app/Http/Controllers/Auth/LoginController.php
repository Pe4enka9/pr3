<?php

namespace App\Http\Controllers\Auth;

use App\Dtos\Auth\LoginDto;
use App\Dtos\ResetPasswordDto;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function resetPasswordForm(): View
    {
        return view('reset-password');
    }

    public function resetPassword(ResetPasswordDto $dto): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->update(['password' => Hash::make($dto->password)]);

        return response()->json(['success' => true]);
    }
}
