# Laravel
## Explicando o Laravel
### Rotas
#### Arquivos
[Documentação](https://laravel.com/docs/5.0/routing)



[Arquivo aonde defende a rota apartir do /](./basico/routes/web.php)

[Arquivo de rotas para API](./basico/routes/api.php)

#### Explicando
De forma prática, aqui você pode ajustar as rotas. Tudo que estiver configurado no web, refere-se ao diretório raiz, no caso o `/`. Se seu dominio for localhost, sera como nesse exemplo, ficaria `http://localhost/rotaexemplo` esse será a url, no caso com base na raiz. Diferente do arquivo *api.php* que coloca o */api* na frente ficando: `http://localhost/api/rotaexemplo/` , caso fosse configurado no arquivo *api.php* por exemplo:

    Route::get('/', function () {
        return view('welcome');
    })->name('index');

Esse é o exemplo mais básico de rota, que no caso vem por padrão na instalação do Laravel inclusive, é válido ressaltar que existe no router suporte a cada método *HTTP* e que o mesmo recebe como argumento uma String para a definição da rota, e uma callback, que pode retornar uma *view* a ser renderizada, assim como pode dar um simples *echo* na tela.

#### Configuração Básica
    //Exemplo basico de rota
    Route::get('/rotaexemplo', function () {
        echo "ola mundo,sem parametro";
    });

Aqui estamos fazendo a configuração para exibir um *echo*, caso seja informado essa rota, no caso se o Laravel dar Match e a rota informado pelo usuário for igual a essa, será renderizado o echo.

#### Rota com um parametro opcional
    //Exemplo com um único parametro opcinal
    Route::get('/rotaexemplo/{param1?}', function ($par=null) {
        return "ola mundo, parametro: ".$par;
    });

Nesse caso estamos lidando com um parametro que pode ou não existir na url, caso não exista, será dado match na rota acima e a rota acima será carregada, caso não, será renderizado essa rota, ou seja na prática pouco importa o interrogação, nesse caso, pois se não tiver parametro, será renderizado a de cima, mas caso você queira criar uma rota que aceite ou não um parametro e quer tratar isso na mesma callback, o interrogação será util, uma vez que a sua ausência indica obrigatóriedade, lembrando inclusive o regex nesse caso. 

#### Rota com mais parametros
    //Exemplo com mais parametros
    Route::get('/rotaexemplo/{param1}/{param2}', function ($p,$q) {
        echo "ola mundo, parametro: ".$p.", ".$q;
    });

No caso de uma callback com *N* parametros o Laravel vai injetar-los dentro da callback conforme a ordem que foram definidos na rota, começando da esquerda para a direita. Nesse caso ambos os parametros seriam obrigatórios se não fosse definido a rota com um ou zero parametros acima, dando o erro *404*.

#### Rotas com regras
    //Exemplo de rotas com regras
    Route::get('/numero/{n}',function($n){
        echo '<h1>O Número da URL é: '.$n.'</h1>';
    })->where(
        'n','[0-9]+'
    );

Nesse caso existe uma regra na rota, ou seja se além de digitar a rota o parametro informado não for condizente com a regex, é exibido um erro *404*. Isso é feito através do método *where*
##### Método where que vem do método http de Route.
    })->where(
        'n','[0-9]+'
    );

O primeiro argumento é o parametro a ser analizado, nesse caso essa regra se aplica ao parametro *N*, o segundo é a regex sem as `\\` e cuidado quando for usar metacaracteres uma vez que aqui temos uma string. Essa regex apenas é valida quando o parametro *N* da url é válida.

#### Grupo de Rotas
    Route::group(['prefix' => 'route'], function () {
    
        Route::get('{nome}/{repetir?}', function ($nome,$repetir = 1) {
            for($i = 0;$i<$repetir;$i++):
                echo "<h3>$nome</h3>";
            endfor;
        })
        ->where('nome','[A-z\s\-]+')
        ->where('repetir','[\d]+')
        ;

    });

Aqui é criado um grupo de rotas, usando o `Route::group`, no caso o primeiro parametro dele é um array de opções sendo o *prefix* o prefixo da url que ele vai abranger, no caso qualquer url que esteja dentro de `http://localhost/route` ele vai atender dentro da callback no argumento de `Route::group`, dentro da callback, você tem prefixos que trabalham dentro do escopo definido pelo `Route::group`, sendo o `http://localhost/route` o prefixo raiz para todas as rotas definidas dentro daquela callback. Nesse exemplo básico, pega-se um valor exibido em `{nome}` e exibe *N* vezes de acordo com o parametro `{reperir}`

##### Multiplas regras
    ->where('nome','[A-z\s\-]+')
    ->where('repetir','[\d]+')
    ;

Lembrando que cada regra deve estar dentro do where, como demonstrado acima. O primeiro que é o parametro nome, apenas aceita letras, hífem e espaço e o segundo dígitos. No caso o `\` não deu problema pelo fato das aspas simples tratar o valor de forma literal, se fosse aspas duplas deveria ser: `"[A-z\\s\\-]+"` e `"[\\d]+"`, ou seja a primeira `\` seria o escape e o segundo indicaria meta-caracter.

#### Nomeando as rotas
    Route::get('/', function () {
        return view('welcome');
    })->name('index');

É possível nomear as rotas para evitar que a mesma seja informado de maneira estática nos links, por exemplo ao invés de você se referenciar a essa rota pelo link direto você pode fazer da seguinte forma:

    <a href="{{route('index')}}">Ir a Página inicial</a>

##### a ligação route('nome') e ->name('nome')
Repare que ao invés de colocar de maneira estática o link até a página eu posso fazer isso através do `route()`, assim como acontece no angular por exemplo, aqui é usado a sintaxe de double mustache, ou seja de bigode duplo. Você envolve certas funções dentro desse double mustache e o laravel vai interpolar, porém isso apenas acontece com arquivos `.blade.php`, que são arquivos que o laravel interpola, resolvendo o resultado quando o mesmo for renderizado. a String passado como parametro deve ser igual ao `->name('')` de alguma rota informada. Ou seja se aqui for `->name('nome')`, no route do arquivo blade deve ficar `{{route('nome')}}`. [Arquivo exemplo](./basico/resources/views/rotas.blade.php).

##### view
O método `view` renderiza um arquivo blade. no caso aqui `view('welcome');` estamos passando o *welcome* como parametro para a função *view*, logo será procurado um arquivo chamado *welcome.blade.php* dentro de *resources/views/*, o arquivo correspondente a essa string deve ser terminado em *blade.php* e deve estar dentro da [pasta de views](./basico/resources/views).

#### Redirecionando
[Arquivo exemplo, rotas com o /api no caso](./basico/routes/api.php)

Existe basicamente duas formas de fazer o redirecionamento, no caso após ser feito o redirecionamento é carregado a [view](./basico/resources/views/rotas.blade.php), porem como esse exemplo está no [arquivo de api](./basico/routes/api.php), logo deve-se colocar o /api na url:

    //Redirecionamento com o metodo redirect.
    Route::redirect('redirect', 'redirecionar', 301);

    //Redirecionamento com a funcao redirect.
    Route::get('redirecionar', function () {
        redirect()->route('nomedarota');
    });

    // Renderizando view
    Route::get('index', function () {
        return view('rotas');
    })->name('nomedarota');

##### Route::redirect
Usando o método redirect dentro do route é a forma mais simples, caso não queira tratar o redirecionamento com nenhuma callback, ele exige 3 parametros, o primeiro e a qual prefixo ele vai tomar essa ação, ou seja em qual URL será o gatilho do redirecionamento, o segundo parametro é para onde vai, qual seria a url de destino e por fim o terceiro parametro é o status http a ser retornado para o navegador, caso tenha uma requisição ajax ou algo assim, recomenda-se usar status na casa dos 300, se for redirecionar. Exemplo: `Route::redirect('redirect', 'redirecionar', 301);`

##### redirect()->route();
Esse já é mais recomendado caso você queira fazer alguma operação antes de redirecionar, no caso essa função deve estar dentro da callback e sendo executada ao final de toda a lógica, ou route aceita como argumento o nome da rota, [conforme explicado aqui.](#nomeando-as-rotas)

#### Outros Métodos além do GET
Para todos os métodos além do GET o Laravel implementa a proteção contra [Cross-site request forgery](https://pt.wikipedia.org/wiki/Cross-site_request_forgery#:~:text=O%20cross%2Dsite%20request%20forgery,a%20partir%20de%20um%20usu%C3%A1rio), logo se faz necessário se ter um token para que esses métodos tenham acesso ao sistema, sendo a exceção apenas os métodos GET e o que for definido explicitamente como exceção no Laravel, porém a exceção deve ser feita de maneira manual.
##### Adicionando as Exceções
Para adicionar uma URL a exceção, você deve cadastrar-la nesse array

    class VerifyCsrfToken extends Middleware
    {
        /**
        * The URIs that should be excluded from CSRF verification.
        *
        * @var array
        */
        protected $except = [
            'api/test' //url cadastrada
        ];
    }

Esse arquivo é o [VerifyCsrfToken.php](./basico/app/Http/Middleware/VerifyCsrfToken.php) e todas as url cadastradas dentro desse array terão todos os seus métodos abertos ao público e sussetíveis a ataques [Cross-site request forgery](https://pt.wikipedia.org/wiki/Cross-site_request_forgery#:~:text=O%20cross%2Dsite%20request%20forgery,a%20partir%20de%20um%20usu%C3%A1rio), se não for tomado o devido cuidado. Dentro do arquivo [arquivo de rotas api](./basico/routes/api.php), estão cadastrados os métodos envolvendo essa rota:
    
    //Outras requisições
    Route::post('test', function (Request $request) {
        return $request;
    });

    Route::put('test', function (Request $request) {
        return $request;
    });

    Route::patch('test', function (Request $request) {
        return $request;
    });

    Route::delete('test', function (Request $request) {
        return $request;
    });

    Route::get('test', function (Request $request) {
        var_dump($request);
    });

Todos os métodos são parecidos com exceção do *GET*, no caso todos aceitam uma callback e eles podem processar as requisições do usuário se assinado da seguinte forma:

    Route::post('test', function (Request $request) {
        return $request;
    });

Esse *Request* que tipifica o *$request* vem de: `Illuminate\Http\Request` e dentro dele está toda a requisição do usuário, ou seja cada *name* dos inputs que o usuário preencheu em um formulário tem o seu correspondente como atributo dentro desse objeto.

### Controller
Para informações sobre a criação de *controller* [você pode ver mais informações aqui](#criando-um-controller). Todos os arquivos de controllers do **Laravel** deve estão nesse [diretório de controllers](./basico/app/Http/Controllers). O exemplo mais básico de controller pode ser visto aqui, essa é a classe criada, quando não é passada a flag `--resource`.

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    class classe extends Controller
    {
    
    }

No caso dos controllers, você usa os métodos para responder requisições, abaixo um exemplo de um método desse, envolvendo a classe ´classe´ e o método `metodo`:

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    class classe extends Controller
    {
        public function metodo($param1,$param2){
            for($i=0; $i<$param1;$i++):
                return $param2;
            endfor;
        }
    }

Já no arquivo de rotas você coloca a seguinte linha, caso você queira que o método acima deva responder a requisição da url */exemplo*

    Route::get('exemplo/{n1}/{n2}','App\Http\Controllers\classe@metodo');

Continua o uso do `Route::`**metodo_HTTP*(), sendo que esses dois parametros aqui: `{n1}/{n2}` corresponde a esses daqui `public function metodo($param1,$param2)`, inclusive na ordem que foram declarados, o *n1* sendo *$param1*, pois são respectivamente o primeiro parametro da url e o primeiro argumento do método e o mesmo raciocínio se aplica a *n2* e *$param2*. Além disso ao invés de passar a callback, você deve passar o *path@metodo* que vai responder a requisição naquela url. No caso passamos o namespace e a classe `App\Http\Controllers\classe`*@*`metodo`, sendo essa classe `class classe extends Controller` e esse `metodo`: `public function metodo($param1,$param2)`. [arquivo controller](./basico/app/Http/Controllers/classe.php)

#### Todas as rotas até agora
    $ php artisan route:list
    +--------+----------------------------------------+-------------------------------+------------+---------------------------------------+------------+
    | Domain | Method                                 | URI                           | Name       | Action                                | Middleware |
    +--------+----------------------------------------+-------------------------------+------------+---------------------------------------+------------+
    |        | GET|HEAD                               | /                             | index      | Closure                               | web        |
    |        | GET|HEAD                               | api/index                     | nomedarota | Closure                               | api        |
    |        | GET|HEAD                               | api/redirecionar              |            | Closure                               | api        |
    |        | GET|HEAD|POST|PUT|PATCH|DELETE|OPTIONS | api/redirect                  |            | Illuminate\Routing\RedirectController | api        |
    |        | GET|HEAD                               | api/test                      |            | Closure                               | api        |
    |        | POST                                   | api/test                      |            | Closure                               | api        |
    |        | PUT                                    | api/test                      |            | Closure                               | api        |
    |        | PATCH                                  | api/test                      |            | Closure                               | api        |
    |        | DELETE                                 | api/test                      |            | Closure                               | api        |
    |        | GET|HEAD                               | api/user                      |            | Closure                               | api        |
    |        |                                        |                               |            |                                       | auth:api   |
    |        | GET|HEAD                               | exemplo/{n1}/{n2}             |            | App\Http\Controllers\classe@metodo    | web        |
    |        | GET|HEAD                               | numero/{n}                    |            | Closure                               | web        |
    |        | GET|HEAD                               | rotaexemplo                   |            | Closure                               | web        |
    |        | GET|HEAD                               | rotaexemplo/{param1?}         |            | Closure                               | web        |
    |        | GET|HEAD                               | rotaexemplo/{param1}/{param2} |            | Closure                               | web        |
    |        | GET|HEAD                               | route                         |            | Closure                               | web        |
    |        | GET|HEAD                               | route/{nome}/{repetir?}       |            | Closure                               | web        |
    +--------+----------------------------------------+-------------------------------+------------+---------------------------------------+------------+

Também é possível criar controladores e de maneira automatizada associar os métodos *HTTP* a eles, no caso passando a flag `--resource` no `php artisan make:controller`, conforme ilustrado [aqui](#criando-um-controller-usando-o-parametro---resource)
#### Controler com -- resource
[arquivo controller](./basico/app/Http/Controllers/resource.php)

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class resource extends Controller
    {
        /**
        * Mostra uma lista do recurso.
        *
        * @return \Illuminate\Http\Response
        */
        public function index()
        {
            //
        }

        /**
        * Mostra o formulário de criação de um novo recurso.
        *
        * @return \Illuminate\Http\Response
        */
        public function create()
        {
            //
        }

        /**
        * Armazene um recurso recém-criado no armazenamento.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
        public function store(Request $request)
        {
            //
        }

        /**
        * Exibe o recurso especificado.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function show($id)
        {
            //
        }

        /**
        * Mostra o formulário para editar o recurso especificado.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function edit($id)
        {
            //
        }

        /**
        * Atualize o recurso especificado no armazenamento.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $id)
        {
            //
        }

        /**
        * Remova o recurso especificado do armazenamento.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function destroy($id)
        {
            //
        }
    }

##### No arquivo de rotas
    Route::resource('controller', 'App\Http\Controllers\resource');

O primeiro parametro é em qual url vai responder e o segundo o path e a classe do controller, no caso se você criar usando o --resources, ou uma classe que tenha essa estrutura, você pode usar o método estático resource para tratar os metodos http de uma rota.

##### Como estão as rotas agora?
    $ php artisan route:list
    +--------+----------------------------------------+-------------------------------+--------------------+---------------------------------------+------------+
    | Domain | Method                                 | URI                           | Name               | Action                                | Middleware |
    +--------+----------------------------------------+-------------------------------+--------------------+---------------------------------------+------------+
    |        | GET|HEAD                               | /                             | index              | Closure                               | web        |
    |        | GET|HEAD                               | api/index                     | nomedarota         | Closure                               | api        |
    |        | GET|HEAD                               | api/redirecionar              |                    | Closure                               | api        |
    |        | GET|HEAD|POST|PUT|PATCH|DELETE|OPTIONS | api/redirect                  |                    | Illuminate\Routing\RedirectController | api        |
    |        | POST                                   | api/test                      |                    | Closure                               | api        |
    |        | PUT                                    | api/test                      |                    | Closure                               | api        |
    |        | PATCH                                  | api/test                      |                    | Closure                               | api        |
    |        | DELETE                                 | api/test                      |                    | Closure                               | api        |
    |        | GET|HEAD                               | api/test                      |                    | Closure                               | api        |
    |        | GET|HEAD                               | api/user                      |                    | Closure                               | api        |
    |        |                                        |                               |                    |                                       | auth:api   |
    |        | GET|HEAD                               | controller                    | controller.index   | App\Http\Controllers\resource@index   | web        |
    |        | POST                                   | controller                    | controller.store   | App\Http\Controllers\resource@store   | web        |
    |        | GET|HEAD                               | controller/create             | controller.create  | App\Http\Controllers\resource@create  | web        |
    |        | PUT|PATCH                              | controller/{controller}       | controller.update  | App\Http\Controllers\resource@update  | web        |
    |        | GET|HEAD                               | controller/{controller}       | controller.show    | App\Http\Controllers\resource@show    | web        |
    |        | DELETE                                 | controller/{controller}       | controller.destroy | App\Http\Controllers\resource@destroy | web        |
    |        | GET|HEAD                               | controller/{controller}/edit  | controller.edit    | App\Http\Controllers\resource@edit    | web        |
    |        | GET|HEAD                               | exemplo/{n1}/{n2}             |                    | App\Http\Controllers\classe@metodo    | web        |
    |        | GET|HEAD                               | numero/{n}                    |                    | Closure                               | web        |
    |        | GET|HEAD                               | rotaexemplo                   |                    | Closure                               | web        |
    |        | GET|HEAD                               | rotaexemplo/{param1?}         |                    | Closure                               | web        |
    |        | GET|HEAD                               | rotaexemplo/{param1}/{param2} |                    | Closure                               | web        |
    |        | GET|HEAD                               | route                         |                    | Closure                               | web        |
    |        | GET|HEAD                               | route/{nome}/{repetir?}       |                    | Closure                               | web        |
    +--------+----------------------------------------+-------------------------------+--------------------+---------------------------------------+------------+

O que nos interessa está aqui:

    |        | GET|HEAD                               | controller                    | controller.index   | App\Http\Controllers\resource@index   | web        |
    |        | POST                                   | controller                    | controller.store   | App\Http\Controllers\resource@store   | web        |
    |        | GET|HEAD                               | controller/create             | controller.create  | App\Http\Controllers\resource@create  | web        |
    |        | PUT|PATCH                              | controller/{controller}       | controller.update  | App\Http\Controllers\resource@update  | web        |
    |        | GET|HEAD                               | controller/{controller}       | controller.show    | App\Http\Controllers\resource@show    | web        |
    |        | DELETE                                 | controller/{controller}       | controller.destroy | App\Http\Controllers\resource@destroy | web        |
    |        | GET|HEAD                               | controller/{controller}/edit  | controller.edit    | App\Http\Controllers\resource@edit    | web        |

Repare que é assimilado os métodos da classe controller automaticamente, apenas usando o `Route::resource('controller', 'App\Http\Controllers\resource');`, se for usar o resource, certifica-se que os métodos estejam com os nomes corretos, porém você pode evitar dor de cabeça usando `--resource` na criação do controller com o *artisan*.



### Artisan
#### Executando um projeto no laravel
    php artisan serve
#### Exibindo listas de todas as rotas
    php artisan route:list

#### Criando um controller
    php artisan make:controller [classe]

O `[classe]` deve ser substituído pela classe correspondente.

##### Criando um controller usando o parametro --resource
    php artisan make:controller [classe] --resource

Quando informado o `--resource` alguns métodos são criados.

## Instalação
### Problema com o PHP ini ou a versão do PHP
Caso de o seguinte erro: 

     Your requirements could not be resolved to an installable set of packages.
        Problem 1
        - laravel/framework[v8.12.0, ..., 8.x-dev] require league/flysystem ^1.1 -> satisfiable by league/flysystem[1.1.0, ..., 1.x-dev].
        - league/flysystem[1.1.0, ..., 1.x-dev] require ext-fileinfo * -> it is missing from your system. Install or enable PHP's fileinfo extension.
        - Root composer.json requires laravel/framework ^8.12 -> satisfiable by laravel/framework[v8.12.0, ..., 8.x-dev].

    To enable extensions, verify that they are enabled in your .ini files:
        - C:\php\php.ini
    You can also run `php --ini` inside terminal to see which files are used by PHP in CLI mode.

Vá até o arquivo `php.ini` e habilite a extensão `php_fileinfo.dll`, da seguinte forma:
Disso: `;extension=fileinfo` para isso `extension=fileinfo`. Geralmente esse arquivo está em *C:\php\php.ini*.