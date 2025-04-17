<?php

namespace Aldo\LaravelPasswordlessLogin\Http\Controllers;

use Aldo\LaravelPasswordlessLogin\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function index(): View
    {
        return view("passwordless::register");
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        try {
            $user = $this->userModel::create($request->validated());

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route("verification.notice");
        } catch (\Exception) {
            return back()->with([
                "status" => false,
                "message" => __("passwordless::app.general-exception")
            ]);
        }
    }
}