<?php

declare(strict_types=1);

use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');

    if (Features::enabled(Features::twoFactorAuthentication())) {
        Route::get('two-factor-challenge', function () {
            if (! session('login.id')) {
                return redirect()->route('login');
            }

            return view('livewire.auth.two-factor-challenge');
        })->name('two-factor.login');
    }
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', VerifyEmail::class)
        ->name('verification.notice');

    Route::get('confirm-password', fn () => view('livewire.auth.confirm-password'))
        ->name('password.confirm');
});
