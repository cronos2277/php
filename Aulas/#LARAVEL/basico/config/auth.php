<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Padrões de autenticação
    |--------------------------------------------------------------------------
    |
    | Esta opção controla a autenticação padrão "guarda" e senha
    | redefina as opções do seu aplicativo. Você pode alterar esses padrões
    | conforme necessário, mas eles são um começo perfeito para a maioria dos aplicativos.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Protetores de autenticação
    |--------------------------------------------------------------------------
    |
    |Em seguida, você pode definir cada proteção de autenticação para seu aplicativo.
    | Claro, uma ótima configuração padrão foi definida para você
    | aqui, que usa o armazenamento de sessão e o provedor de usuário Eloquent.
    |
    | Todos os drivers de autenticação têm um provedor de usuário. Isso define como o
    | os usuários são realmente recuperados de seu banco de dados ou outro armazenamento
    | mecanismos usados ​​por este aplicativo para manter os dados do usuário.
    |
    | Com suporte: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Provedores de usuários
    |--------------------------------------------------------------------------
    |
    |Todos os drivers de autenticação têm um provedor de usuário. Isso define como o
    | os usuários são realmente recuperados de seu banco de dados ou outro armazenamento
    | mecanismos usados ​​por este aplicativo para manter os dados do usuário.
    |
    | Se você tiver várias tabelas ou modelos de usuário, você pode configurar vários
    | fontes que representam cada modelo / mesa. Essas fontes podem então
    | ser atribuído a qualquer proteção de autenticação extra que você tenha definido.
    |
    | Com suporte: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redefinindo senhas
    |--------------------------------------------------------------------------
    |
    | Você pode especificar várias configurações de redefinição de senha se tiver mais
    | de uma tabela de usuário ou modelo no aplicativo e você deseja ter
    | configurações de redefinição de senha separadas com base nos tipos de usuário específicos.
    |
    | O tempo de expiração é o número de minutos que o token de redefinição deve ser
    | considerado válido. Este recurso de segurança mantém os tokens de curta duração, então
    | eles têm menos tempo para serem adivinhados. Você pode alterar isso conforme necessário.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tempo limite de confirmação de senha
    |--------------------------------------------------------------------------
    |
    |Aqui você pode definir a quantidade de segundos antes de uma confirmação de senha
    | atinge o tempo limite e o usuário é solicitado a inserir novamente sua senha por meio do
    | tela de confirmação. Por padrão, o tempo limite dura três horas.
    |
    */

    'password_timeout' => 10800,

];
