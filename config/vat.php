<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default driver
    |--------------------------------------------------------------------------
    |
    | This is default driver that will be used by Manager class if no specific
    | driver is specified at runtime.
    |
    */
    'default' => 'stack',

    /*
    |--------------------------------------------------------------------------
    | Drivers
    |--------------------------------------------------------------------------
    |
    | Drivers are the various services that can be used to validate VAT numbers.
    | Usually a driver only supports a subset of countries.
    | A list of institutions that provide VAT number information can be found
    | from the list here: https://dinero.dk/tips/tjek-udenlandsk-cvr/
    |
     */
    'drivers' => [
        'stack' => [
            'drivers' => ['cvr_api', 'abstract_api'],
        ],
        'cvr_api' => [
            'access_token' => env('VAT_CVR_API_ACCESS_TOKEN'),
            'user_agent' => env('VAT_CVR_API_USER_AGENT'),
        ],
        'abstract_api' => [
            'api_key' => env('VAT_ABSTRACT_API_KEY'),
        ],
    ],
];
