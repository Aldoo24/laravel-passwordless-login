<?php

namespace Tests;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Workbench\App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use WithWorkbench, InteractsWithViews, RefreshDatabase;

    protected $enablesPackageDiscoveries = true;
    protected $user;

    protected function getPackageProviders($app): array
    {
        return [
            'Aldo\LaravelPasswordlessLogin\Providers\PasswordlessServiceProvider'
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'PasswordlessLogin' => 'Aldo\LaravelPasswordlessLogin\Facades\PasswordlessLogin',
        ];
    }

    protected function defineEnvironment($app)
    {
        tap($app['config'], function (Repository $config) {
            $config->set([
                'passwordless.model.namespace' => 'Workbench\App\Models\User',
                'passwordless.url.route' => 'home',
                'passwordless.routes.flag' => true,
                'session.driver' => 'array',
            ]);
        });
    }

    protected function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->user = User::create([
                'name' => 'Aldo',
                'email' => 'aldo@example.com',
            ]);
        });

        parent::setUp();
    }
}
