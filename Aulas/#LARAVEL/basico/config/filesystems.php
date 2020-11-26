<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disco do sistema de arquivos padrão
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar o disco padrão do sistema de arquivos que deve ser usado
    | pela estrutura. O disco "local", bem como uma variedade de nuvem
    | discos baseados estão disponíveis para seu aplicativo. Basta guardar!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Disco de sistema de arquivos em nuvem padrão
    |--------------------------------------------------------------------------
    |
    | Muitos aplicativos armazenam arquivos localmente e na nuvem. Por esta
    | razão, você pode especificar um driver "nuvem" padrão aqui. Este motorista
    | será vinculado como a implementação do disco em nuvem no contêiner.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Discos de sistema de arquivos
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar quantos "discos" de sistema de arquivos desejar, e você
    | pode até configurar vários discos do mesmo driver. Padrões têm
    | foi configurado para cada driver como um exemplo das opções necessárias.
    |
    | Drivers Suportados: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Links Simbólicos
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar os links simbólicos que serão criados quando o
    | O comando `storage: link` Artisan é executado. As chaves do array devem ser
    | as localizações dos links e os valores devem ser seus alvos.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
