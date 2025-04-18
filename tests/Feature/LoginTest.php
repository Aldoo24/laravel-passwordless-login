<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    protected $followRedirects = true;

    public function test_redirected_to_login_notice_after_login()
    {
        $this->actingAs($this->user)
            ->fromRoute('login')
            ->post(route('login.send'), ['email' => $this->user->email])
            ->assertRedirectToRoute('login.notice')
            ->assertSessionHas([
                'status' => true,
                'email' => $this->user->email,
                'message' => __('passwordless::app.login.email.email-sent'),
                'subMessage' => __('passwordless::app.login.email.message'),
            ]);
    }

    public function test_login_notice_has_resend_button()
    {
        $this->actingAs($this->user)
            ->withSession([
                'status' => true,
                'email' => $this->user->email,
                'message' => __('passwordless::app.login.email.email-sent'),
                'subMessage' => __('passwordless::app.login.email.message'),
            ])
            ->get(route('login.notice'))
            ->assertSeeText(__('passwordless::app.login.email.resend'));
    }
}