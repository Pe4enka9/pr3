<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CallbackController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisterController::class, 'registerForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/reset-password', [LoginController::class, 'resetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('reset-password');

    Route::get('/callback', [CallbackController::class, 'callbackForm'])->name('callback');
    Route::post('/callback', [CallbackController::class, 'callback'])->name('callback');
});
