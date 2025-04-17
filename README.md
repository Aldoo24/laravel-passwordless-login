# Laravel Passwordless Login

## A login link generator for Laravel

This package provides a temporary signed route that can be used to login a user. You can implement the login yourself or
you can use the implementation provided by this package. It includes a must verify email registration and a passwordless 
login implementation. 

### Installation

```bash
  composer require aldo/laravel-passwordless-login
```
Publish the config file

```bash
  php artisan vendor:publish --tag=passwordless-config
```

### Usage

In the published config file you should set the correct user model namespace and the name of the route that is going to 
be used to verify the generated login link. Your can also set the expiration time you want for the link.

```php
<?php

return [
    /*
    |
    | The namespace of your applications user model
    |
    */
    "model" => [
        "namespace" => "\App\Models\User",
    ],

    /*
    |
    | The route name and the url expiration in minutes
    |
    */
    "url" => [
        "route" => "login.verify",
        "expire" => 5,
    ],

    /*
    |--------------------------------------------------------------------------------
    | Only applicable if you are using the provided authentication implementation
    |--------------------------------------------------------------------------------
    |
    | Change flag to true if you want to use the provided implementation routes. 
    | This flag is necessary for not loading the routes if you don't want to use the default implementation.
    | This way you can avoid route collision.
    | 
    | The name of the home route to redirect to after login
    |
    */
    "routes" => [
        "flag" => false,
        
        "home" => "home",
    ],
];
```
To generate the login link use the provided facade

```php
use App\Models\User;
use Aldo\LaravelPasswordlessLogin\Facades\PasswordlessLogin;

function sendLoginLink()
{
    $user = User::first();
    
    $url = PasswordlessLogin::forUser($user)->generate();
    
    // You can also add remember me (by default it's false)
    $url = PasswordlessLogin::forUser($user)->remember()->generate();    
    
    // Send the url to the user
}
```
---

**If you want to use the provided authentication implementation follow the steps below.**

- Run the migrations

```bash
  php artisan migrate
```
The packages migration modifies the users table making the password column nullable.

If you want to publish the migration files run:

```bash
  php artisan vendor:publish --tag=passwordless-migrations
````

- In the config file change the flag to true and set the correct route name for your home page

```php
/*
|--------------------------------------------------------------------------------
| Only applicable if you are using the provided authentication implementation
|--------------------------------------------------------------------------------
|
| Change flag to true if you want to use the provided implementation routes. 
| This flag is necessary for not loading the routes if you don't want to use the default implementation.
| This way you can avoid route collision.
| 
| The name of the home route to redirect to after login
|
*/
"routes" => [
    "flag" => false, // change to true
    
    "home" => "home",
],
```

- In your user model implement `Illuminate\Contracts\Auth\MustVerifyEmail`. The package uses it in the user registration.

If you want to publish the views and the localization files run:

```bash
  php artisan vendor:publish --tag=passwordless-views
```
