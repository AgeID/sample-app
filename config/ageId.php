<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AgeID Config
    |--------------------------------------------------------------------------
    |
    | Configuration items for AgeID
    |
    */

    'baseURL'           => env('AGEID_URL', 'https://www.ageid.com'),
    'callbackURL'       => env('AGEID_CALLBACK_URL'),
    'redirectURL'       => env('AGEID_REDIRECT_URL'),
    'clientId'          => env('AGEID_CLIENT_ID'),
    'pilot'             => env('AGEID_PILOT', 'frontdesk'),
    'codeURL'           => env('AGEID_CODE_URL', '/sso/v1/code'),
    'tokenURL'          => env('AGEID_TOKEN_URL', '/sso/v1/token'),
    'retryCounter'      => env('AGEID_RETRY_COUNTER', 10),
    'retryInterval'     => env('AGEID_RETRY_INTERVAL', 10),
    'EncryptionKey'     => env('AGEID_KEY'),
    'TimeoutInMinutes'  => env('AGEID_TIMEOUT', 60),

];
