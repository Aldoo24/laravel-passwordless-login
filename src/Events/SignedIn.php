<?php

namespace Aldo\LaravelPasswordlessLogin\Events;

use Aldo\LaravelPasswordlessLogin\Facades\PasswordlessLogin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignedIn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $signedUrl;
    public Authenticatable $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Authenticatable $user, bool $rememberMe = false)
    {
        $this->user = $user;

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
}
