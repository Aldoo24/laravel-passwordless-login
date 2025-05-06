<?php

namespace Aldo\LaravelPasswordlessLogin\Http\Controllers;

abstract class Controller
{
    public string $userModel;

    public function __construct()
    {
        $this->userModel = config()->string('passwordless.model.namespace', '\App\Models\User');
    }
}
