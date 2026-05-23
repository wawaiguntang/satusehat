<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Client Credentials
    |--------------------------------------------------------------------------
    | Diperoleh dari https://platform.satusehat.kemkes.go.id
    */
    'client_id'     => env('SATUSEHAT_CLIENT_ID', ''),
    'client_secret' => env('SATUSEHAT_CLIENT_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    | 'production' atau 'staging'
    */
    'env' => env('SATUSEHAT_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    */
    'urls' => [
        'production' => [
            'base' => 'https://api-satusehat.kemkes.go.id/fhir-r4/v1',
            'auth' => 'https://api-satusehat.kemkes.go.id/oauth2/v1',
        ],
        'staging' => [
            'base' => 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1',
            'auth' => 'https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    | Cache store yang digunakan untuk menyimpan OAuth2 token.
    | Gunakan store yang persistent (misal: 'redis', 'file', 'database').
    | Nilai null berarti menggunakan default cache store Laravel.
    */
    'cache_store' => env('SATUSEHAT_CACHE_STORE', null),

];
