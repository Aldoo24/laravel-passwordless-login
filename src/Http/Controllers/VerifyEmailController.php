<?php

namespace Aldo\LaravelPasswordlessLogin\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifyEmailController extends Controller
{
    public function notice(): View
    {
        return view("passwordless::verify-email");
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()->route(config("passwordless.routes.home"));
    }

    public function send(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route(config("passwordless.routes.home"));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with("message", __("passwordless::app.email-verification.new-email-sent"));
    }
}