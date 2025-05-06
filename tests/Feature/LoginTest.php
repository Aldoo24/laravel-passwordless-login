<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_see_login_page(): void
    {
        $response = $this->assertGuest()
            ->get(route('login'));

        $response->assertViewIs('passwordless::login')
            ->assertSeeHtml([
                __('passwordless::app.login.title'),
                __('passwordless::app.login.labels.email'),
                __('passwordless::app.login.labels.remember-me'),
                __('passwordless::app.login.sign-in'),
                __('passwordless::app.login.no-account'),
                __('passwordless::app.register.sign-up'),
            ]);
    }

    public function test_redirected_to_login_notice_after_login(): void
    {
        $response = $this->assertGuest()
            ->fromRoute('login')
            ->post(route('login.send'), ['email' => $this->user->email]);

        $response->assertValid();

        $response->assertViewIs('passwordless::login-notice')
            ->assertSeeHtml(__('passwordless::app.login.email.resend'));
    }

    public function test_login_fails_with_wrong_email(): void
    {
        $response = $this->assertGuest()
            ->from(route('login'))
            ->post(route('login.send'), [
                'email' => 'user@example.com',
            ]);

        $response->assertInvalid('email');

        $response->assertRedirectToRoute('login');
    }
}
