<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver de sessão padrão
    |--------------------------------------------------------------------------
    |
    | Esta opção controla o "driver" de sessão padrão que será usado no
    | solicitações de. Por padrão, usaremos o driver nativo leve, mas
    | você pode especificar qualquer um dos outros drivers maravilhosos fornecidos aqui.
    |
    | Com suporte: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Sessão vitalícia
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar o número de minutos que deseja para a sessão
    | para poder permanecer inativo antes de expirar. Se você os quiser
    | para expirar imediatamente no fechamento do navegador, defina essa opção.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Criptografia de Sessão
    |--------------------------------------------------------------------------
    |
    | Esta opção permite que você especifique facilmente que todos os seus dados de sessão
    | deve ser criptografado antes de ser armazenado. Toda a criptografia será executada
    | automaticamente pelo Laravel e você pode usar a Sessão normalmente.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    |Localização do arquivo da sessão
    |--------------------------------------------------------------------------
    |
    | Ao usar o driver de sessão nativa, precisamos de um local onde a sessão
    | os arquivos podem ser armazenados. Um padrão foi definido para você, mas um diferente
    | a localização pode ser especificada. Isso só é necessário para sessões de arquivo.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Conexão de banco de dados de sessão
    |--------------------------------------------------------------------------
    |
    | Ao usar os drivers de sessão "banco de dados" ou "redis", você pode especificar um
    | conexão que deve ser usada para gerenciar essas sessões. Isto deveria
    | correspondem a uma conexão nas opções de configuração do banco de dados.
    |
    */

    'connection' => env('SESSION_CONNECTION', null),

    /*
    |--------------------------------------------------------------------------
    |Tabela de banco de dados de sessão
    |--------------------------------------------------------------------------
    |
    | Ao usar o driver de sessão "banco de dados", você pode especificar a tabela que
    | deve usar para gerenciar as sessões. Claro, um padrão sensato é
    | fornecido para você; no entanto, você pode alterar isso conforme necessário.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Armazenamento de cache de sessão
    |--------------------------------------------------------------------------
    |
    | Ao usar um dos back-ends de sessão orientados por cache do framework, você pode
    | liste um armazenamento de cache que deve ser usado para essas sessões. Este valor
    | deve corresponder a um dos "armazenamentos" de cache configurados do aplicativo.
    |
    | Afeta: "apc", "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE', null),

    /*
    |--------------------------------------------------------------------------
    | Loteria de varredura de sessão
    |--------------------------------------------------------------------------
    |
    | Alguns drivers de sessão devem varrer manualmente seu local de armazenamento para obter
    | livrar-se de sessões antigas do armazenamento. Aqui estão as chances de
    | acontecer em um determinado pedido. Por padrão, as chances são de 2 em 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nome do Cookie da Sessão
    |--------------------------------------------------------------------------
    |
    | Aqui você pode alterar o nome do cookie usado para identificar uma sessão
    | instância por ID. O nome especificado aqui será usado sempre que um
    | O novo cookie de sessão é criado pela estrutura para cada driver.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Caminho do Cookie da Sessão
    |--------------------------------------------------------------------------
    |
    | O caminho do cookie da sessão determina o caminho para o qual o cookie irá
    | ser considerado como disponível. Normalmente, este será o caminho raiz do
    | seu aplicativo, mas você está livre para alterá-lo quando necessário.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Domínio do Cookie da Sessão
    |--------------------------------------------------------------------------
    |
    | Aqui você pode alterar o domínio do cookie usado para identificar uma sessão
    | em seu aplicativo. Isso determinará quais domínios o cookie é
    | disponível em seu aplicativo. Um padrão sensato foi definido.
    |
    */

    'domain' => env('SESSION_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | HTTPS apenas cookies
    |--------------------------------------------------------------------------
    |
    | Ao definir esta opção como verdadeira, os cookies de sessão só serão enviados de volta
    | para o servidor se o navegador tiver uma conexão HTTPS. Isso vai manter
    | o cookie seja enviado a você se não puder ser feito com segurança.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | Acesso HTTP apenas
    |--------------------------------------------------------------------------
    |
    | Definir este valor como verdadeiro impedirá que o JavaScript acesse o
    | valor do cookie e o cookie só estará acessível por meio
    | o protocolo HTTP. Você é livre para modificar esta opção, se necessário.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Cookies do mesmo site
    |--------------------------------------------------------------------------
    |
    | Esta opção determina como seus cookies se comportam quando as solicitações entre sites
    | ocorrem e podem ser usados ​​para mitigar ataques CSRF. Por padrão, nós
    | irá definir este valor como "lax", uma vez que este é um valor padrão seguro.
    |
    | Com suporte: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',

];
