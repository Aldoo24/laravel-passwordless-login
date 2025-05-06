<?php

namespace Aldo\LaravelPasswordlessLogin\Events;

use Aldo\LaravelPasswordlessLogin\Facades\PasswordlessLogin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignedIn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $signedUrl;
    public object $user;
    private string $userModel;

    /**
     * Create a new event instance.
     */
    public function __construct(object|string|int $user, bool $rememberMe = false)
    {
        $this->userModel = config()->string('passwordless.model.namespace', '\App\Models\User');

        $this->user = $this->resolveUser($user);

        $this->signedUrl = PasswordlessLogin::forUser($user)->remember($rememberMe)->generate();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    private function resolveUser(object|string|int $user): mixed
    {
        return match (true) {
            $user instanceof Authenticatable, is_a($user, $this->userModel, true) => $this->user = $user,
            is_string($user) && ($foundUser = $this->findByEmail($user)) => $this->user = $foundUser,
            is_int($user) && ($foundUser = $this->findById($user)) => $this->user = $foundUser,
            default => throw new ModelNotFoundException(__('passwordless::app.login.notification.user-not-found')),
        };
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
