<?php

return [

<<<<<<< HEAD
=======
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

>>>>>>> a7996714d1f20851bfcfe2cd4ae3c473456a1b6a
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

<<<<<<< HEAD
    'mikrotik' => [
    'host' => env('MIKROTIK_HOST', 'http://192.168.10.1'),
    'user' => env('MIKROTIK_USER', 'admin'),
    'pass' => env('MIKROTIK_PASS', 'admin'),
    ],

=======
>>>>>>> a7996714d1f20851bfcfe2cd4ae3c473456a1b6a
];
