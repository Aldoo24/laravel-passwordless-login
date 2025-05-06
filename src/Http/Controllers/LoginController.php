<?php

namespace Aldo\LaravelPasswordlessLogin\Http\Controllers;

use Aldo\LaravelPasswordlessLogin\Events\SignedIn;
use Aldo\LaravelPasswordlessLogin\Http\Requests\LoginRequest;
use Aldo\LaravelPasswordlessLogin\Http\Requests\LoginVerificationRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('passwordless::login');
    }

    public function notice(): View
    {
        return view('passwordless::login-notice');
    }

    public function send(LoginRequest $request): RedirectResponse
    {
        try {
            $user = app($this->userModel)::where('email', $request->email)->first();

            $rememberMe = $request->validated('remember_me');

            event(new SignedIn($user, isset($rememberMe)));

            return redirect()
                ->route('login.notice')
                ->with([
                    'status' => true,
                    'email' => $request->email,
                    'message' => __('passwordless::app.login.email.email-sent'),
                    'sub_message' => __('passwordless::app.login.email.message'),
                ])
                ->setStatusCode(301);
        } catch (\Exception) {
            return back()->with([
                'status' => false,
                'message' => __('passwordless::app.general-exception'),
            ]);
        }
    }

    public function verify(LoginVerificationRequest $request): RedirectResponse
    {
        $user = app($this->userModel)::where('email', $request->email)->first();

        Auth::login($user, (bool) $request->remember);

        $request->session()->regenerate();

        return redirect()->route(config('passwordless.home.route', 'home'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
