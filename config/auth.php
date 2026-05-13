<?php

use App\Models\User;
use App\Models\Admin;

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |------------------------------------------------------------------
    | Guards
    |------------------------------------------------------------------
    */
    'guards' => [

        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // ✅ ADD THIS
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    /*
    |------------------------------------------------------------------
    | Providers
    |------------------------------------------------------------------
    */
    'providers' => [

        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],

        // ✅ ADD THIS
        'admins' => [
            'driver' => 'eloquent',
            'model' => Admin::class,
        ],
    ],

    /*
    |------------------------------------------------------------------
    | Password Reset
    |------------------------------------------------------------------
    */
    'passwords' => [

        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],

        // (optional) for admin reset later
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
