<?php

return [
    /*
    |
    | The namespace of your applications user model
    |
    */
    'model' => [
        'namespace' => "\App\Models\User",
    ],

    /*
    |
    | The route name and the url expiration in minutes
    |
    */
    'url' => [
        'route' => 'login.verify',
        'expire' => 5,
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
    'routes' => [
        'flag' => false,

        'home' => 'home',
    ],
];
