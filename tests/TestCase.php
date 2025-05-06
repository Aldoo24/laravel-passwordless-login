<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected $followRedirects = true;
    protected object $user;

    protected function setUp(): void
    {
        parent::setUp();

        $userModel = config()->string('passwordless.model.namespace', '\App\Models\User');

        $this->user = app($userModel)::create([
            'name' => 'Aldo',
            'email' => 'user@example.com',
        ]);
    }
}
