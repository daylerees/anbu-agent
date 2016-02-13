<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Anbu Service Token
    |--------------------------------------------------------------------------
    |
    | Before you can report to Anbu, you'll need to get a token. You can find this
    | token in your profile on the http://anbu.io website.
    |
    */

    'token' => env('ANBU_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Enable Anbu Profiling
    |--------------------------------------------------------------------------
    |
    | Send reports to the Anbu service for every request performed within the
    | application. By default, this value is bound to the 'APP_DEBUG' environment
    | key.
    |
    */

    'enabled' => env('APP_DEBUG')

];
