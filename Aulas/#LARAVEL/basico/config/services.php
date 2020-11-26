<?php

return [

    /*
    |--------------------------------------------------------------------------
    |Serviços terceirizados
    |--------------------------------------------------------------------------
    |
    | Este arquivo é para armazenar as credenciais para serviços de terceiros, como
    | como Mailgun, Postmark, AWS e muito mais. Este arquivo fornece o de fato
    | localização para este tipo de informação, permitindo que os pacotes tenham
    | um arquivo convencional para localizar as várias credenciais de serviço.
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

];
