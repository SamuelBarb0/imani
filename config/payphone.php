<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PayPhone API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PayPhone payment gateway integration
    | https://www.docs.payphone.app/api-implementacion
    |
    */

    'token' => env('PAYPHONE_TOKEN'),

    'store_id' => env('PAYPHONE_STORE_ID'),

    'api_url' => env('PAYPHONE_API_URL', 'https://pay.payphonetodoesposible.com/api'),

    'country_code' => env('PAYPHONE_COUNTRY_CODE', '593'),

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */

    // Payment confirmation timeout (in seconds)
    'timeout' => 300, // 5 minutes

    // Currency (ISO 4217)
    'currency' => 'USD',

    // Enable/disable test mode
    'test_mode' => env('PAYPHONE_TEST_MODE', false),

];
