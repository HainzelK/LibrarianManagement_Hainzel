<?php

return [

    /*
    |----------------------------------------------------------------------
    | Authentication Defaults
    |----------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'), // Default guard for authentication
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'), // Password reset broker
    ],

    /*
    |----------------------------------------------------------------------
    | Authentication Guards
    |----------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | You may specify guards for different user types, e.g., 'admin' or 'librarian'.
    |
    | Supported: "session", "api"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Custom admin guard for admin users
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // Custom librarian guard for librarian users
        'librarian' => [
            'driver' => 'session',
            'provider' => 'librarians',
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | User Providers
    |----------------------------------------------------------------------
    |
    | Each authentication guard has a user provider which defines how the
    | users are retrieved from your database or other storage systems.
    | You can define multiple user providers for different models/tables.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class), // Default user model
        ],

        // Custom provider for admins (assuming you have an Admin model)
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class, // Custom Admin model
        ],

        // Custom provider for librarians (assuming you have a Librarian model)
        'librarians' => [
            'driver' => 'eloquent',
            'model' => App\Models\Librarian::class, // Custom Librarian model
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Resetting Passwords
    |----------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality, including the table utilized for token storage
    | and the user provider that is invoked to actually retrieve users.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Password Confirmation Timeout
    |----------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | window expires and users are asked to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
