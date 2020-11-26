<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Broadcaster padrão
    |--------------------------------------------------------------------------
    |
    | Esta opção controla o transmissor padrão que será usado pelo
    | estrutura quando um evento precisa ser transmitido. Você pode definir isso para
    | qualquer uma das conexões definidas na matriz "conexões" abaixo.
    |
    | Com suporte: "pusher", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Conexões de transmissão
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir todas as conexões de transmissão que serão usadas
    | para transmitir eventos para outros sistemas ou através de websockets. Amostras de
    | cada tipo de conexão disponível é fornecido dentro desta matriz.
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
