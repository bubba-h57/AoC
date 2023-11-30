<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'advent_of_code' => [
        'session_cookie' => env('AOC_SESSION_COOKIE'),
        'default_year'   => env('AOC_DEFAULT_YEAR', \Illuminate\Support\Carbon::now()->year),
    ],

];
