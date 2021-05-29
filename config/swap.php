<?php

/*
 * This file is part of Laravel Swap.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Options.
    |--------------------------------------------------------------------------
    |
    | The options to pass to Swap amongst:
    |
    | * cache_ttl: The cache ttl in seconds.
    */
    'options' => [
        'cache_ttl' => 86400 // 24 hour
    ],

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    |
    | This option specifies the services to use with their name as key and
    | their config as value.
    |
    | Here is the config spec for each service:
    |
    | * "central_bank_of_czech_republic", "central_bank_of_republic_turkey", "european_central_bank", "google",
    |   "national_bank_of_romania", "webservicex", "russian_central_bank", "cryptonator" can be enabled with "true" as value.
    |
    | * 'fixer' => [
    |       'access_key' => 'secret', // Your app id
    |       'enterprise' => true, // True if your AppId is an enterprise one
    |   ]
    |
    | * 'currency_layer' => [
    |       'access_key' => 'secret', // Your app id
    |       'enterprise' => true, // True if your AppId is an enterprise one
    |   ]
    |
    | * 'forge' => [
    |       'api_key' => 'secret', // The API token
    |   ]
    |
    | * 'open_exchange_rates' => [
    |       'app_id' => 'secret', // Your app id
    |       'enterprise' => true, // True if your AppId is an enterprise one
    |   ]
    |
    | * 'xignite' => [
    |       'token' => 'secret', // The API token
    |   ]
    |
    | * 'currency_data_feed' => [
    |       'api_key' => 'secret', // The API token
    |   ]
    |
    | * 'currency_converter' => [
    |       'api_key' => 'access_key', // The API token
    |       'enterprise' => true, // True if your AppId is an enterprise one
    |   ]

    |
    */
    'services' => [
        // 'currency_layer' => ['access_key' => '62deca8011b048dc56ed1e4988d31eab', 'enterprise' => false], 
        'fixer' => ['access_key' => 'c112f3482274f1e8f8bd77a584e4e2eb', 'enterprise' => false],
        //'fixer' => ['access_key' => 'c14918a163d54cd4446728384f1e4635', 'enterprise' => false],
        // 'european_central_bank' => true,
        // 'exchange_rates_api' => true,
        // 'open_exchange_rates' => ['app_id' => '89084bd3770f4bf78e419b5080e5ed1b', 'enterprise' => false],

        // 'fixer' => ['access_key' => 'YOUR_KEY', 'enterprise' => false],
        // 'currency_layer' => ['access_key' => 'secret', 'enterprise' => false],],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | This option specifies the Laravel cache store to use.
    |
    | 'cache' => 'file'
    */
    'cache' => 'file',

    /*
    |--------------------------------------------------------------------------
    | Http Client.
    |--------------------------------------------------------------------------
    |
    | The HTTP client service name to use.
    */
    'http_client' => null,

    /*
    |--------------------------------------------------------------------------
    | Request Factory.
    |--------------------------------------------------------------------------
    |
    | The Request Factory service name to use.
    */
    'request_factory' => null,
];
