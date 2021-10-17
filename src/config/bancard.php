<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Bancard Keys
    |--------------------------------------------------------------------------
    |
    | The Bancard public key and private key give you access to Bancard's
    | API.
    |
    */
    'public' => env('BANCARD_PUBLIC_KEY', ''),

    'private' => env('BANCARD_PRIVATE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Bancard Environment
    |--------------------------------------------------------------------------
    |
    | This value determines if your application is using the staging environment from Bancard's API.
    |
    */
    'staging' => (bool) env('BANCARD_STAGING', true),

    /*
    |--------------------------------------------------------------------------
    | Bancard URL
    |--------------------------------------------------------------------------
    */

    // The return URL for the Single Buy Operation
    'single_buy_return_url' => env('BANCARD_SINGLE_BUY_RETURN_URL', ''), 
    
    // The cancel URL for the Single Buy Operation
    'single_buy_cancel_url' => env('BANCARD_SINGLE_BUY_CANCEL_URL', ''), 
    
    // The return URL for the New Card Operation
    'new_card_return_url' => env('BANCARD_NEW_CARD_RETURN_URL', ''), 
];