<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nome de conexão de fila padrão
    |--------------------------------------------------------------------------
    |
    | A API de fila do Laravel suporta uma variedade de back-ends por meio de um único
    | API, fornecendo acesso conveniente a cada back-end usando o mesmo
    | sintaxe para cada um. Aqui você pode definir uma conexão padrão.
    |
    */

    'default' => env('QUEUE_CONNECTION', 'sync'),

    /*
    |--------------------------------------------------------------------------
    | Conexões de fila
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar as informações de conexão para cada servidor que
    | é usado por seu aplicativo. Uma configuração padrão foi adicionada
    | para cada back-end enviado com o Laravel. Você está livre para adicionar mais.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => 0,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'your-queue-name'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Trabalhos de fila falhados
    |--------------------------------------------------------------------------
    |
    | Essas opções configuram o comportamento do registro de trabalho da fila com falha para que você
    | pode controlar qual banco de dados e tabela são usados ​​para armazenar os trabalhos que
    | Falhou. Você pode alterá-los para qualquer banco de dados / tabela que desejar.
    |
    */

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];
