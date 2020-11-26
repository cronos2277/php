<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ver caminhos de armazenamento
    |--------------------------------------------------------------------------
    |
    | A maioria dos sistemas de modelos carregam modelos do disco. Aqui você pode especificar
    | uma série de caminhos que devem ser verificados para suas visualizações. Claro
    | o caminho de visualização usual do Laravel já foi registrado para você.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Caminho de visualização compilado
    |--------------------------------------------------------------------------
    |
    | Esta opção determina onde todos os templates Blade compilados estarão
    | armazenados para seu aplicativo. Normalmente, isso está dentro do armazenamento
    | diretório. No entanto, como de costume, você pode alterar esse valor.
    |*/

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
