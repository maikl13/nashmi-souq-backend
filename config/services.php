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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'mpgs' => [
        'api_url' => env('MPGS_MODE') == 'test' ? env('MPGS_TEST_API_URL') :  env('MPGS_LIVE_API_URL'),
        'merchant' => env('MPGS_MODE') == 'test' ? env('MPGS_TEST_MERCHANT') :  env('MPGS_LIVE_MERCHANT'),
        'merchant_id' => env('MPGS_MODE') == 'test' ? env('MPGS_TEST_MERCHANT_ID') :  env('MPGS_LIVE_MERCHANT_ID'),
        'api_password' => env('MPGS_MODE') == 'test' ? env('MPGS_TEST_API_PASSWORD') :  env('MPGS_LIVE_API_PASSWORD'),
        'operation' => env('MPGS_MODE') == 'test' ? env('MPGS_TEST_OPERATION') :  env('MPGS_LIVE_OPERATION'),
    ]

];
