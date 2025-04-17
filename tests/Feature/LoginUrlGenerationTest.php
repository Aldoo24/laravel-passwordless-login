<?php

namespace Tests\Feature;

use Aldo\LaravelPasswordlessLogin\Facades\PasswordlessLogin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class LoginUrlGenerationTest extends TestCase
{
    public function test_login_url_is_generated_and_works()
    {
        $url = PasswordlessLogin::forUser($this->user)->generate();

        $response = $this->actingAs($this->user)->get($url);

        $response->assertOk();
    }

    public function test_no_user_provided_fails()
    {
        $this->assertThrows(
            fn() => PasswordlessLogin::generate(),
            \Exception::class,
            __('passwordless::app.login.notification.no-user')
        );
    }

    public function test_non_existing_user_fails()
    {
        $this->assertThrows(
            fn() => PasswordlessLogin::forUser(1000)->generate(),
            ModelNotFoundException::class,
            __('passwordless::app.login.notification.user-not-found')
        );
    }
}