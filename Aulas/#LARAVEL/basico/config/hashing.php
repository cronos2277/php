<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Driver Hash Padrão
    |--------------------------------------------------------------------------
    |
    | Esta opção controla o driver de hash padrão que será usado para hash
    | senhas para seu aplicativo. Por padrão, o algoritmo bcrypt é
    | usava; no entanto, você permanece livre para modificar essa opção se desejar.
    |
    | Com suporte: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | Opções Bcrypt
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar as opções de configuração que devem ser usadas quando
    | as senhas são hash usando o algoritmo Bcrypt. Isso vai permitir que você
    | para controlar o tempo que leva para o hash da senha fornecida.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    |Opções de argônio
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar as opções de configuração que devem ser usadas quando
    | as senhas são hash usando o algoritmo de argônio. Isso permitirá que você
    | para controlar o tempo que leva para o hash da senha fornecida.
    |
    */

    'argon' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
    ],

];
