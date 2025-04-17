<?php

namespace Aldo\LaravelPasswordlessLogin\Providers;

use Aldo\LaravelPasswordlessLogin\Events\SignedIn;
use Aldo\LaravelPasswordlessLogin\Listeners\SendSignInNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class PasswordlessServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(
            SignedIn::class,
            SendSignInNotification::class,
        );

        $this->loadRoutesFrom(__DIR__ . "/../../routes/web.php");

        $this->loadMigrationsFrom(__DIR__ . "/../../database/migrations");

        $this->publishesMigrations([
            __DIR__."/../../database/migrations" => database_path("migrations")
        ], "passwordless-migrations");

        $this->mergeConfigFrom(__DIR__ . "/../../config/passwordless.php", "passwordless");

        $this->publishes([
            __DIR__."/../../config/passwordless.php" => config_path("passwordless.php")
        ], "passwordless-config");

        $this->loadViewsFrom(__DIR__."/../../resources/views", "passwordless");

        $this->loadTranslationsFrom(__DIR__ . "/../../lang", "passwordless");

        $this->publishes([
            __DIR__."/../../resources/views" => resource_path("views/vendor/passwordless"),
            __DIR__."/../../lang" => lang_path("vendor/passwordless"),
        ], "passwordless-views");
    }
}
