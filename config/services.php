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

    'nbe_mpgs' => [
        'api_url' => env('NBE_MPGS_MODE') == 'test' ? env('NBE_MPGS_TEST_API_URL') :  env('NBE_MPGS_LIVE_API_URL'),
        'merchant' => env('NBE_MPGS_MODE') == 'test' ? env('NBE_MPGS_TEST_MERCHANT') :  env('NBE_MPGS_LIVE_MERCHANT'),
        'merchant_id' => env('NBE_MPGS_MODE') == 'test' ? env('NBE_MPGS_TEST_MERCHANT_ID') :  env('NBE_MPGS_LIVE_MERCHANT_ID'),
        'api_password' => env('NBE_MPGS_MODE') == 'test' ? env('NBE_MPGS_TEST_API_PASSWORD') :  env('NBE_MPGS_LIVE_API_PASSWORD'),
        'operation' => env('NBE_MPGS_MODE') == 'test' ? env('NBE_MPGS_TEST_OPERATION') :  env('NBE_MPGS_LIVE_OPERATION'),
    ],

    'hyperpay' => [
        'api_url' => env('HYPERPAY_MODE') == 'test' ? env('HYPERPAY_TEST_API_URL') :  env('HYPERPAY_LIVE_API_URL'),
        'access_token' => env('HYPERPAY_MODE') == 'test' ? env('HYPERPAY_TEST_ACCESS_TOKEN') :  env('HYPERPAY_LIVE_ACCESS_TOKEN'),
        'entity_id' => env('HYPERPAY_MODE') == 'test' ? env('HYPERPAY_TEST_ENTITY_ID') :  env('HYPERPAY_LIVE_ENTITY_ID'),
        'mada_entity_id' => env('HYPERPAY_MODE') == 'test' ? env('HYPERPAY_TEST_MADA_ENTITY_ID') :  env('HYPERPAY_LIVE_MADA_ENTITY_ID'),
        'ssl' => env('HYPERPAY_MODE') == 'test' ? env('HYPERPAY_TEST_SSL') :  env('HYPERPAY_LIVE_SSL'),
    ]
];
