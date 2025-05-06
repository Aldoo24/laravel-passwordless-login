<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_see_register_page(): void
    {
        $response = $this->assertGuest()
            ->get(route('register'));

        $response->assertViewIs('passwordless::register')
            ->assertSeeHtml([
                __('passwordless::app.register.title'),
                __('passwordless::app.register.labels.name'),
                __('passwordless::app.register.labels.email'),
                __('passwordless::app.register.sign-up'),
                __('passwordless::app.register.have-account'),
                __('passwordless::app.login.sign-in'),
            ]);
    }

    public function test_redirect_to_verification_notice_after_register(): void
    {
        $response = $this->assertGuest()
            ->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'User',
                'email' => 'user@example.com',
            ]);

        $response->assertValid();

        $response->assertRedirectToRoute('verification.notice');

        $response->assertViewIs('passwordless::verify-email')
            ->assertSeeHtml([
                __('passwordless::app.login.email.no-email-received'),
                __('passwordless::app.login.email.resend'),
            ]);
    }

    public function test_register_fails_with_existing_email(): void
    {
        $response = $this->assertGuest()
            ->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Aldo',
                'email' => $this->user->email,
            ]);

        $response->assertInvalid('email');

        $response->assertRedirectToRoute('register');
    }
}
