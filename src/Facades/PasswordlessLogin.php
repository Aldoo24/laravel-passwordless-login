<?php

namespace Aldo\LaravelPasswordlessLogin\Facades;

use Illuminate\Support\Facades\Facade;

class PasswordlessLogin extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return \Aldo\LaravelPasswordlessLogin\PasswordlessLogin::class;
    }
}
