<?php

use Aldo\LaravelPasswordlessLogin\Http\Controllers\LoginController;
use Aldo\LaravelPasswordlessLogin\Http\Controllers\RegisterController;
use Aldo\LaravelPasswordlessLogin\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

if (config('passwordless.routes.flag')) {
    Route::group(['middleware' => ['web']], function () {
        Route::group(['middleware' => ['guest']], function () {
            Route::get('/login', [LoginController::class, 'index'])
                ->name('login');

            Route::group(['prefix' => '/login', 'as' => 'login.'], function () {
                Route::get('/notice', [LoginController::class, 'notice'])
                    ->name('notice');

                Route::post('/send', [LoginController::class, 'send'])
                    ->middleware('throttle:6,1')
                    ->name('send');

                Route::get('/verify/{email}/{remember}', [LoginController::class, 'verify'])
                    ->name('verify');
            });

            Route::get('/register', [RegisterController::class, 'index'])
                ->name('register');

            Route::post('/register', [RegisterController::class, 'register'])
                ->name('register.store');
        });

        Route::group(['middleware' => ['auth']], function () {
            Route::group(['prefix' => 'email', 'as' => 'verification.'], function () {
                Route::get('/verify', [VerifyEmailController::class, 'notice'])
                    ->name('notice');

                Route::get('/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
                    ->middleware('signed')
                    ->name('verify');

                Route::post('/verification-notification', [VerifyEmailController::class, 'send'])
                    ->middleware('throttle:6,1')
                    ->name('send');
            });

            Route::post('/logout', [LoginController::class, 'logout'])
                ->name('logout');
        });
    });
}
