<?php

namespace Aldo\LaravelPasswordlessLogin\Listeners;

use Aldo\LaravelPasswordlessLogin\Notifications\SignIn;

class SendSignInNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->notify(new SignIn($event->signedUrl));
    }
}
