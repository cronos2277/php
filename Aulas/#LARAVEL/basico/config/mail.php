<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mailer padrão
    |--------------------------------------------------------------------------
    |
    | Esta opção controla o mailer padrão que é usado para enviar qualquer e-mail
    | mensagens enviadas por seu aplicativo. Mailers alternativos podem ser configurados
    | e usado conforme necessário; entretanto, este mailer será usado por padrão.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Configurações do Mailer
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar todos os mailers usados ​​por seu aplicativo mais
    | suas respectivas configurações. Vários exemplos foram configurados para
    | você e você são livres para adicionar os seus, conforme necessário.
    |
    | O Laravel suporta uma variedade de drivers de "transporte" de e-mail para serem usados ​​enquanto
    | enviando um e-mail. Você irá especificar qual você está usando para o seu

    | mailers abaixo. Você é livre para adicionar mailers adicionais conforme necessário.
    || Com suporte: "smtp", "sendmail", "mailgun", "ses",
    |            "postmark", "log", "array"
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => '/usr/sbin/sendmail -bs',
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    |Endereço "from" global
    |--------------------------------------------------------------------------
    |
    | Você pode desejar que todos os e-mails enviados por seu aplicativo sejam enviados de
    | o mesmo endereço. Aqui, você pode especificar um nome e endereço que seja
    | usado globalmente para todos os e-mails enviados por seu aplicativo.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Markdown Mail
    |--------------------------------------------------------------------------
    |
    | Se você estiver usando renderização de e-mail baseada em Markdown, você pode configurar seu
    | caminhos de tema e componente aqui, permitindo que você personalize o design
    | dos e-mails. Ou você pode simplesmente ficar com os padrões do Laravel!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
