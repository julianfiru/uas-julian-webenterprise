<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Passport Guard
    |--------------------------------------------------------------------------
    |
    | Here you may specify which authentication guard Passport will use when
    | authenticating users. This value should correspond with one of your
    | guards that is already present in your "auth" configuration file.
    |
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Encryption Keys
    |--------------------------------------------------------------------------
    |
    | Passport uses encryption keys while generating secure access tokens for
    | your application. By default, the keys are stored as local files but
    | can be set via environment variables when that is more convenient.
    |
    */

    'private_key' => env('PASSPORT_PRIVATE_KEY'),

    'public_key' => env('PASSPORT_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Passport Database Connection
    |--------------------------------------------------------------------------
    |
    | By default, Passport's models will utilize your application's default
    | database connection. If you wish to use a different connection you
    | may specify the configured name of the database connection here.
    |
    */

    'connection' => env('PASSPORT_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Token Expiration
    |--------------------------------------------------------------------------
    |
    | Here you may define the number of minutes that access tokens will be
    | valid for. The default is 30 minutes. You can override this value in
    | your .env file using the PASSPORT_TOKEN_EXPIRE_MINUTES variable.
    |
    */

    'token_expire_minutes' => env('PASSPORT_TOKEN_EXPIRE_MINUTES', 30),

    /*
    |--------------------------------------------------------------------------
    | JWT Hash Algorithm
    |--------------------------------------------------------------------------
    |
    | This option controls the hash algorithm used for JWT tokens. By default
    | it uses sha256. This value should not be changed unless necessary.
    |
    */

    'hash_algorithm' => env('PASSPORT_HASH_ALGORITHM', 'sha256'),

];
