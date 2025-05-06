<?php

namespace Aldo\LaravelPasswordlessLogin;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\URL;

class PasswordlessLogin
{
    private string $userModel;
    private object $user;
    private int $rememberMe = 0;

    public function __construct()
    {
        $this->userModel = config()->string('passwordless.model.namespace', '\App\Models\User');
    }

    public function forUser(object|string|int $user): self
    {
        match (true) {
            $user instanceof Authenticatable, is_a($user, $this->userModel, true) => $this->user = $user,
            is_string($user) && ($foundUser = $this->findByEmail($user)) => $this->user = $foundUser,
            is_int($user) && ($foundUser = $this->findById($user)) => $this->user = $foundUser,
            default => throw new ModelNotFoundException(__('passwordless::app.login.notification.user-not-found')),
        };

        return $this;
    }

    public function remember(bool $rememberMe = true): self
    {
        $this->rememberMe = $rememberMe ? 1 : 0;

        return $this;
    }

    public function generate(): string
    {
        if (empty($this->user)) {
            throw new \Exception(__('passwordless::app.login.notification.no-user'));
        }

        return URL::temporarySignedRoute(
            name: config('passwordless.url.route'),
            expiration: now()->addMinutes(config()->integer('passwordless.url.expire', 5)),
            parameters: [
                'email' => $this->user->email,
                'remember' => $this->rememberMe,
            ],
        );
    }

    private function findByEmail(string $email)
    {
        return app($this->userModel)::where('email', $email)->first();
    }

    private function findById(int $id)
    {
        return app($this->userModel)::find($id)?->first();
    }
}
