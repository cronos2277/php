# Laravel

* Rotas [ir](#rotas)
* Controllers [ir](#controller)
* Views [ir](#views)
* Migrations [ir](#migrations)
* Models [ir](#model)

* Tinker [ir](#tinker)
* Artisan [ir](#artisan)
* Problemas e instalação [ir](#instalação)
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

##### Método index
    public function index()
    {
        echo '<a href="./controller/create">adicionar novo</a>';
        echo "<table id='resource' class='resource'border=2px width=50% height=10% align=center>";
        foreach(session('clientes') as $key=>$value){
            echo "<tr class='tr-resource'>";
                echo "<td class='td-key'>".$key."</td>";
                echo "<td class='td-value'>".$value."</td>";
                echo "<td class='td-edit'><a href='./controller/$key' class='td-link'/>Detalhes</a></td>";                
                echo "<td class='td-edit'><a href='./controller/$key/edit' class='td-link'/>Editar</a></td>";                
                echo "<td class='td-edit'>
                    <form method='post' action='./controller/$key' onsubmit='confirm(`Deseja realmente apagar {$value}`)'>
                        <input type='hidden' name='_token' value=".csrf_token().">
                        <input type='hidden' name='_method' value='DELETE' />
                        <input type='submit' value='Apagar' />
                    </form>
                </td>";                
            echo "</tr>";
        }
        echo "</table>";
    }

Esse método acima responde a:

    |        | GET|HEAD                               | controller                    | controller.index   | App\Http\Controllers\resource@index   | web        |

No caso, qunado você cria uma rota usando o `--resource`, cria-se dentre vários métodos o index, para chamalo você usa o path definido aqui `Route::resource('controller', 'App\Http\Controllers\resource');`, seguido de `.index`, nesse exemplo ficaria: `controller.index`.

##### método create e store
**create**, responde em: `|        | GET|HEAD                               | controller/create             | controller.create  | App\Http\Controllers\resource@create  | web        |`

    public function create()
    {
        
        echo "   
            <h1>Adicionar Cliente</h1>       
            <form method='post' action='/controller'>
            <input type='hidden' name='_token' value=".csrf_token().">
                <input name='nome' />
                <input type='submit' value='enviar' />
            </form>
        ";
    }

**store**, responde em: `|        | POST                                   | controller                    | controller.store   | App\Http\Controllers\resource@store   | web        |`

    public function store(Request $request)
    {    
        $clientes = session('clientes');
        $id = count($clientes) +1;        
        $clientes[$id] = $request->nome;
        session(['clientes' => $clientes]);
        return redirect()->route('controller.index');        
    }

O método *create* responde através do método **GET** no path `/create`, ou seja nessa url você deve criar a view para cadastro de usuário caso precise de um formulário, no caso o nome automático que é criado para essa rota é `.create`, ficando nesse exemplo `controller.index`.

O método *store* que responde através do **POST**, no caso essa rota é a rota raiz `/`, porém o *GET* chama o `controller.index` e o *POST* responde com esse método. O nome dessa rota é o `.store`, sendo nesse exemplo o `controller.store`.

##### método Edit e update
edit, responde em: `|        | GET|HEAD                               | controller/{controller}/edit  | controller.edit    | App\Http\Controllers\resource@edit    | web        |`

    public function edit($id)
    {
        $clientes = session('clientes');
        echo "<h1>Edição de {$clientes[$id]}";
        echo "                  
            <form method='post' action='/controller/{$id}'>            
            <input type='hidden' name='_token' value=".csrf_token().">
                <input type='hidden' name='_method' value='PUT' />
                <input name='nome' value='{$clientes[$id]}'/>
                <input type='submit' value='enviar' />
            </form>
        ";
        echo '<br>';
        echo "<a href='/controller'>voltar</a>";
    }

update, responde em: `|        | PUT|PATCH                              | controller/{controller}       | controller.update  | App\Http\Controllers\resource@update  | web        |`

    public function update(Request $request, $id)
    {
        $clientes = session('clientes');               
        $clientes[$id] = $request->nome;
        session(['clientes' => $clientes]);
        return redirect()->route('controller.index'); 
    }

O *edit* é semelhante ao *create*, porém nele você colocar um formulário de edição, ao contrário de *create*, que foi projetado para um formulário de criação. O edit responde na rota `/{id}/edit` e ele deve enviar uma requisição do tipo *PUT* ou *PATCH* para a raiz `/`, porém como o HTML apenas suporta o POST e o GET no formulário você deve fazer isso colocando um input desses `<input type='hidden' name='_method' value='PUT' />` para *PUT* ou `<input type='hidden' name='_method' value='PATCH' />` para *PATCH*, ou a segunda forma, caso você esteja usando o blade, é usar a anotação dentro do formulário html `@method('PUT')` ou `@method('PATCH')`, que no caso adiciona o input type exatamente igual ao explicado aqui. O update, ele responde no *PUT* ou *PATCH* de uma requisição usando o formulário *EDIT*, ou seja o formulário do *create* você envia para o **store** assim como o formulario do *edit* você envia para o *update*, a grande diferença do update para o store, é que o store responde requisição post e o update requisições *patch* e *put*, logo é no método update que fica a regra de negócio para mudança e no edit o formulário para tal. Para chamar o edit nesse exemplo `controller.edit `, já o update `controller.update `, ou seja respectivamente `.edit` e `.update`.

##### método show
O método show responde: `|        | GET|HEAD                               | controller/{controller}       | controller.show    | App\Http\Controllers\resource@show    | web        |`

    public function show($id)
    {
        $clientes = session('clientes');        
        echo "<h1> O cliente selecionado é: {$id} => {$clientes[$id]} </h1>";
        echo "<a href='/controller'>voltar</a>";
    }

O método show é semelhante ao index, mas ele foi projetado para exibir detalhes de um único registro, ao passo que o index de todos. Esse método suporta o GET e após a raiz você deve passar o parametro a ser usado como ID. exemplo `/2/`, ou seja esse método é acionado quando passado um parametro na raiz. Para chamalo `.show` ou como está nesse exemplo `controller.show`.

#### Método Destroy
O método destroy, responde em: `|        | DELETE                                 | controller/{controller}       | controller.destroy | App\Http\Controllers\resource@destroy | web        |`

     public function destroy($id)
    {
        $clientes = session('clientes');
        array_splice($clientes,$id,1);
        session(['clientes' => $clientes]);
        return redirect()->route('controller.index');
    }

Esse método ele foi projeto para excluir registros, no caso espera-se que a requisição delete venha do index e e ai esse método é chamado, para se chamar ele é `.destroy` ou como é o exemplo `controller.destroy`, esse método responde no método *delete* da raiz e exige um parametro que é o id, assim sendo, ex: `/2/` => no *delete*. No caso do [método index](#método-index), o destroy corresponde a seguinte parte:

    <form method='post' action='./controller/$key' onsubmit='confirm(`Deseja realmente apagar {$value}`)'>
        <input type='hidden' name='_token' value=".csrf_token().">
        <input type='hidden' name='_method' value='DELETE' />
        <input type='submit' value='Apagar' />
    </form>

No caso é feito uma requisição post, mas devido a `<input type='hidden' name='_method' value='DELETE' />` o Laravel interpreta isso como uma requisição *DELETE*, se for usar isso no blade, deve-se usar a anotação `@method('DELETE')`, que irá adicionar essa linha dentro do formulário.

#### Tokens
Quando você vai enviar um formulário, devido a proteção contra [Cross-site request forgery](https://pt.wikipedia.org/wiki/Cross-site_request_forgery#:~:text=O%20cross%2Dsite%20request%20forgery,a%20partir%20de%20um%20usu%C3%A1rio), você deve adicionar tokens no seus formulários, para isso existe algumas opções, a primeira como foi feita: `<input type='hidden' name='_token' value=".csrf_token().">`, nesse caso você cria um token manualmente, o que foi útil nesse caso dos formulários criados de maneira simplificada usando *echo*, mas também é possível gerar isso dentro de um arquivo blade usando a anotação `@csrf`, essa anotação irá adicionar essa linha `<input type='hidden' name='_token' value=".csrf_token().">` automaticamente dentro de seu formulário.

#### @method('')
Um formulário HTML apenas permite requisições *GET* ou *POST*, caso você queira fazer requisições para outros métodos como *PUT*, *PATCH*, *DELETE* por exemplo, você precisa que além do [token](#tokens), tenha também essa linha `<input type='hidden' name='_method' value='[HTTP Método]' />` no seu formulário, estando no value **DELETE ou PUT ou PATCH** ou qualquer outro método que você queira, com esse input o Laravel processa o formulário com um método diferente do especificado no formulário. Ou ao invés de por esse input, nos arquivos blades, você tem a opção pelo `@method('[metodo]')`, devendo substituir o `[metodo]`, pelo método **HTTP** correspondente.

#### Arquivos de exemplos
[classe](./basico/app/Http/Controllers/classe.php)

[resource](./basico/app/Http/Controllers/resource.php)

[arquivo de rotas](./basico/routes/web.php)

### Views

#### Estrutura
##### Rotas
    Route::get('view/{n}','App\Http\Controllers\view@view_simples');
    Route::get('view','App\Http\Controllers\view@template');

Inicialmente é feito o carregamento, se houver parametro carrega a view simples, se não houver carrega o template, no caso é carregado no arquivo de rotas **web**: [web.php](./basico/routes/web.php)

##### Controller
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    class view extends Controller
    {
        public function view_simples($parametro){
            return view('pasta.arquivo_simples',['parametro' => $parametro]);
        }

        public function template(){
            return view('pasta.template');
        }
    }

Aqui está o arquivo de controller [view.php](./basico/app/Http/Controllers/view.php), você pode passar ou não parametro para a *view*, dessa forma `return view('pasta.arquivo_simples',['parametro' => $parametro]);`, ou `return view('pasta.arquivo_simples',compact(['parametro']);`, sendo esse segundo uma forma mais compacta, no caso é pego a varável com o nome **$parametro** *que deve existir* e passa como o nome de **$parametro** dentro da *view* também. [O diretório aonde está as views](./basico/resources/views), no o ['pasta.'](./basico/resources/views/pasta) é a pasta aonde está o arquivo de view, para cada subdiretório um novo ponto deve ser adicionado, todos os arquivos de view devem estar em `resources/views` e caso tiver subdiretórios usar o `.` ao invés de `\`, no caso isso apenas vale caso a view esteja dentro de uma pasta.

##### Arquivo Blade Básico
[Exemplo Básico](./basico/resources/views/pasta/arquivo_simples.blade.php)

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Arquivo Blade Simples</title>
    </head>
    <body>
    <!-- Criando desvio condicional -->
        @if (true)
            <h3>Será exibido</h3>
        @else
            <h3>Não será exibido</h3>
        @endif 

    <!-- criando laço for -->
        @for ($i = 0; $i < 0; $i++)
            <p>Não será exibido</p>
        @endfor

    <!-- Criando laço while -->
        @while (false)
            <p>Não será exibido</p>
        @endwhile

    <!-- Exibindo valores php -->
        <p>Exibindo o parametro passado: {{ $parametro }}</p>
    </body>
    </html>

O Blade permite a inserção de certas tags que podem ser interpoladas pelo laravel, o double mustache *{{}}* é interpolado pelo laravel e processado como um código PHP qualquer, assim como ocorre no Angular por exemplo, além disso:

        @if (true)
            <h3>Será exibido</h3>
        @else
            <h3>Não será exibido</h3>
        @endif 

Desvio condicional, o valor passado dentro dos parentes vai ser intrepretado da mesma forma que é o php, dentro dos parenteses deve passar uma lógica booleana, seguindo a sintaxe do PHP.

    @for ($i = 0; $i < 0; $i++)
        <p>Não será exibido</p>
    @endfor

    @while (false)
        <p>Não será exibido</p>
    @endwhile

O mesmo ocorre com os laços de repetições, todo esse código estão disponíveis dentro dos templates blade do *PHP*, dentro dos parentes segue-se as regras do PHP para um laço for e while. No geral os comandos especiais do blade segue a lógica do PHP, mas existe coisas exclusivas do Laravel e o blade torna o código muito mais legível.

##### Exemplo com template
[Exemplo Básico](./basico/resources/views/pasta/template.blade.php)

    @extends('pasta.extensao_template')
    @section('secao')
        <!-- Executa codigo php-->
        @php
            $arr = [1,2,3,4,5,6,null]
        @endphp 

        <!-- laço for each igual ao PHP. -->
        @foreach ($arr as $item)
            {{ $item }}
        @endforeach

        <!-- Switch igual ao PHP -->
        @switch(0)
            @case(1)
                <p>Não vai ser exibido.</p>
                @break
            @case(2)
                <p>Não vai ser exibido.</p>
                @break
            @default
                <p>Vai se exibir esse valor.</p>
        @endswitch

        <!-- forelse imprime o array, ou executa o empty se vazio -->
        @forelse ([] as $item)
            <p>forelse: {{$item}}</p>
        @empty
            <p>caso de array vazio imprimirá isso</p>
        @endforelse

        <!-- Comando equivalente ao dd do Laravel, que é um var_dump mais bonito e organizado. -->
        @dump($arr)

        <!-- Impressao crua -->
        @{{ arr[3] }}

        <!-- o equivalente ao echo -->
        {!! $arr[1] !!}

        <!-- verifica se variavel existe -->
        @isset($arr)
            <p>Variável $arr está setada </p>
        @endisset

        <!-- verifica se a variavel está vazia. -->
        @empty(!$arr)
            <p>Variável $arr não está vazia </p>
        @endempty    
        
    @endsection

##### O arquivo linkado do @extends('pasta.extensao_template')

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Template</title>
    </head>
    <body>
        @yield('secao')
    </body>
    </html>

##### Explicando: @yield('secao') @extends('pasta.extensao_template') @section('secao')
Para usar um template se faz necessário usar essas três tags em conjunto, o *@yeld*, vai no arquivo HTML e com o *@yeld* você indica aonde será renderizado o o template, no caso qual é o espaço destinado ao output do arquivo do qual se é extendido com o *@section('secao')*.

    <body>
        @yield('secao')
    </body>

Aqui estamos definindo que as chamadas usando o **@section('secao')** será encaixado nesse espaço alocado pelo *@yeld*. Esse é o arquivo visual.

    @extends('pasta.extensao_template')
    @section('secao')

Em resumo: Aqui estamos importando através do *('pasta.extensao_template')*, essa tag seria equivalente ao import do php, no caso do section é um bloco que começa com *@section('secao')* e termina no *@endsection*, e esse bloco será encaixado dentro o *@yield('secao')* contido no arquivo *@extends('pasta.extensao_template')*.

##### Executando código PHP
será passado uma espécie *"eval"* dentro do que estiver dentro desse bloco `@php` e `@endphp`.

    @php
        $arr = [1,2,3,4,5,6,null]
    @endphp 

##### Foreach
     @foreach ($arr as $item)
        {{ $item }}
    @endforeach

##### Switch case
     @switch(0)
        @case(1)
            <p>Não vai ser exibido.</p>
            @break
        @case(2)
            <p>Não vai ser exibido.</p>
            @break
        @default
            <p>Vai se exibir esse valor.</p>
        @endswitch

##### foreach com suporte a nulo 
    @forelse ([] as $item)
        <p>forelse: {{$item}}</p>
    @empty
        <p>caso de array vazio imprimirá isso</p>
    @endforelse

Caso o array esteja vazio, é executado o que está após o `@empty`.

##### var_dump elegante do Laravel
    @dump($arr)

O `@dump` usa a função `dd()`, que é um `var_dump` mais elegante.

##### o equivalente do isset e empty do Laravel.
    @isset($arr)
        <p>Variável $arr está setada </p>
    @endisset

    @empty(!$arr)
        <p>Variável $arr não está vazia </p>
    @endempty    

Esses funcionam respectivamente igual ao `isset` e o `empty` do *PHP*. No caso do **empty** cuidado para confundir com o **forelse**, do **forelse** não aceita parametros, diferente desses.

##### Output
     <!-- Impressao crua -->
        @{{ arr[3] }}

    <!-- o equivalente ao echo -->
        {!! $arr[1] !!}

Você usa o `@{{``}}` caso queira fazer uma impressão equivalente ao `<pre>` do html. Esse código `{!! $arr[1] !!}` ele exibe de maneira igual ao echo do php.

#### Exemplos mais avançados   

##### route() e request()
[avancado.blade.php](./basico/resources/views/componentes/avancado.blade.php)

        <nav>
            <ul>
                <li><a href="{{route('avancado',1)}}" class="{{(request()->is('view_avancado/1'))?'selected-item':'unselected'}}">Componente 1 </a></li>
                <li><a href="{{route('avancado',2)}}" class="{{(request()->is('view_avancado/2'))?'selected-item':'unselected'}}">Componente 2 </a></li>
                <li><a href="{{route('avancado',3)}}" class="{{(request()->is('view_avancado/3'))?'selected-item':'unselected'}}">Componente 3 </a></li>
                <li><a href="{{route('avancado',4)}}" class="{{(request()->is('view_avancado/4'))?'selected-item':'unselected'}}">Componente 4 </a></li>
            </ul>
        <nav>

##### route
 Route faz o redirecionamento para uma rota estabelecida, nesse exemplo `route('avancado',1)` o primeiro argumento é o nome da rota definido aqui `Route::get('view_avancado/{n?}','App\Http\Controllers\view_avancado@response')->name('avancado')->where('n','\d');`, no caso aqui `->name('avancado')`, alem disso você pode passar parametro como segundo argumento, como no exemplo `route('avancado',1)`, nesse caso é passado como parametro o `/1/` a url, ficando nesse exemplo `/view_avancado/1`.      

 ##### request
 Dentro desse objeto está todas as informações do usuário, e dentro desse objeto tem uma função que verifica se você está em uma determinada rota que é o método `->is()`, que aceita como argumento uma string da rota a ser analisada.Segue um exemplo desse request:
    
    Illuminate\Http\Request {#43 ▼
    #json: null
    #convertedFiles: null
    #userResolver: Closure($guard = null) {#1185 ▼
        class: "Illuminate\Auth\AuthServiceProvider"
        this: Illuminate\Auth\AuthServiceProvider {#135 …}
        use: {▼
        $app: Illuminate\Foundation\Application {#2 …}
        }
        file: "C:\Users\crono\OneDrive\Área de Trabalho\php\Aulas\#LARAVEL\basico\vendor\laravel\framework\src\Illuminate\Auth\AuthServiceProvider.php"
        line: "105 to 107"
    }
    #routeResolver: Closure() {#1186 ▼
        class: "Illuminate\Routing\Router"
        this: Illuminate\Routing\Router {#26 …}
        use: {▼
        $route: Illuminate\Routing\Route {#1120 …}
        }
        file: "C:\Users\crono\OneDrive\Área de Trabalho\php\Aulas\#LARAVEL\basico\vendor\laravel\framework\src\Illuminate\Routing\Router.php"
        line: "661 to 663"
    }
    +attributes: Symfony\Component\HttpFoundation\ParameterBag {#45 ▼
        #parameters: []
    }
    +request: Symfony\Component\HttpFoundation\InputBag {#51 ▶}
    +query: Symfony\Component\HttpFoundation\InputBag {#51 ▼
        #parameters: []
    }
    +server: Symfony\Component\HttpFoundation\ServerBag {#47 ▼
        #parameters: array:28 [▼
        "DOCUMENT_ROOT" => "C:\Users\crono\OneDrive\Área de Trabalho\php\Aulas\#LARAVEL\basico\public"
        "REMOTE_ADDR" => "::1"
        "REMOTE_PORT" => "63456"
        "SERVER_SOFTWARE" => "PHP 7.4.1 Development Server"
        "SERVER_PROTOCOL" => "HTTP/1.1"
        "SERVER_NAME" => "localhost"
        "SERVER_PORT" => "8090"
        "REQUEST_URI" => "/view_avancado/3"
        "REQUEST_METHOD" => "GET"
        "SCRIPT_NAME" => "/index.php"
        "SCRIPT_FILENAME" => "C:\Users\crono\OneDrive\Área de Trabalho\php\Aulas\#LARAVEL\basico\public\index.php"
        "PATH_INFO" => "/view_avancado/3"
        "PHP_SELF" => "/index.php/view_avancado/3"
        "HTTP_HOST" => "localhost:8090"
        "HTTP_CONNECTION" => "keep-alive"
        "HTTP_UPGRADE_INSECURE_REQUESTS" => "1"
        "HTTP_USER_AGENT" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36"
        "HTTP_ACCEPT" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9"
        "HTTP_SEC_FETCH_SITE" => "same-origin"
        "HTTP_SEC_FETCH_MODE" => "navigate"
        "HTTP_SEC_FETCH_USER" => "?1"
        "HTTP_SEC_FETCH_DEST" => "document"
        "HTTP_REFERER" => "http://localhost:8090/view_avancado/2"
        "HTTP_ACCEPT_ENCODING" => "gzip, deflate, br"
        "HTTP_ACCEPT_LANGUAGE" => "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7"
        "HTTP_COOKIE" => "XSRF-TOKEN=eyJpdiI6ImJvdGNjR1dWc3RmSlhJM3lBU1N3TkE9PSIsInZhbHVlIjoiSTZwRzFqSFZ0RDAxd1NXd25KRW5KVDZNdUlPbllhTTJSZ1lQcHlZbzB2R2wxOWhyT3B6V1VxY2JrQWtkVGw1MEtyNzk3W ▶"
        "REQUEST_TIME_FLOAT" => 1606872717.2538
        "REQUEST_TIME" => 1606872717
        ]
    }
    +files: Symfony\Component\HttpFoundation\FileBag {#48 ▼
        #parameters: []
    }
    +cookies: Symfony\Component\HttpFoundation\InputBag {#46 ▼
        #parameters: array:2 [▼
        "XSRF-TOKEN" => "FszpGYBRz1vPtalPZpAtQ6uSTmlqYlr2Apwfcl0l"
        "laravel_session" => "AFZCVw5N8oqIAD6ZWkefVzNM3MN33plhMvTNpeh5"
        ]
    }
    +headers: Symfony\Component\HttpFoundation\HeaderBag {#49 ▼
        #headers: array:13 [▼
        "host" => array:1 [▼
            0 => "localhost:8090"
        ]
        "connection" => array:1 [▼
            0 => "keep-alive"
        ]
        "upgrade-insecure-requests" => array:1 [▼
            0 => "1"
        ]
        "user-agent" => array:1 [▼
            0 => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36"
        ]
        "accept" => array:1 [▼
            0 => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9"
        ]
        "sec-fetch-site" => array:1 [▼
            0 => "same-origin"
        ]
        "sec-fetch-mode" => array:1 [▼
            0 => "navigate"
        ]
        "sec-fetch-user" => array:1 [▼
            0 => "?1"
        ]
        "sec-fetch-dest" => array:1 [▼
            0 => "document"
        ]
        "referer" => array:1 [▼
            0 => "http://localhost:8090/view_avancado/2"
        ]
        "accept-encoding" => array:1 [▼
            0 => "gzip, deflate, br"
        ]
        "accept-language" => array:1 [▼
            0 => "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7"
        ]
        "cookie" => array:1 [▼
            0 => "XSRF-TOKEN=eyJpdiI6ImJvdGNjR1dWc3RmSlhJM3lBU1N3TkE9PSIsInZhbHVlIjoiSTZwRzFqSFZ0RDAxd1NXd25KRW5KVDZNdUlPbllhTTJSZ1lQcHlZbzB2R2wxOWhyT3B6V1VxY2JrQWtkVGw1MEtyNzk3W ▶"
        ]
        ]
        #cacheControl: []
    }
    #content: null
    #languages: null
    #charsets: null
    #encodings: null
    #acceptableContentTypes: null
    #pathInfo: "/view_avancado/3"
    #requestUri: "/view_avancado/3"
    #baseUrl: ""
    #basePath: null
    #method: "GET"
    #format: null
    #session: Illuminate\Session\Store {#1231 ▼
        #id: "AFZCVw5N8oqIAD6ZWkefVzNM3MN33plhMvTNpeh5"
        #name: "laravel_session"
        #attributes: array:3 [▶]
        #handler: Illuminate\Session\FileSessionHandler {#1230 ▼
        #files: Illuminate\Filesystem\Filesystem {#148}
        #path: "C:\Users\crono\OneDrive\Área de Trabalho\php\Aulas\#LARAVEL\basico\storage\framework/sessions"
        #minutes: "120"
        }
        #started: true
    }
    #locale: null
    #defaultLocale: "en"
    -preferredFormat: null
    -isHostValid: true
    -isForwardedValid: true
    -isSafeContentPreferred: null
    basePath: ""
    format: "html"
    }

##### Componentes

    @switch($param)
        @case(1)
            @component('componentes.componente1')
                <h1>Componente 1</h1>    
            @endcomponent
            @break
        @case(2)
            @component('componentes.componente2',['param1' => 'Parametro1', 'param2' => 'parametro2'])
                <h1>Componente 2</h1> 
            @endcomponent 
            @break        
        @case(3)
            @component('componentes.componente3')
                <h1>Componentes 3</h1>
            @endcomponent
            @break
        @case(4)
            @component('componentes.componente4')
                <h1>Componentes 4</h1>
            @endcomponent
            @break
        @default
            <h1>Página Padrão </h1>
    @endswitch

Aqui acima temos um exemplo de como funciona os componentes usando: `@component`, exemplo:

        @component('componentes.componente2',['param1' => 'Parametro1', 'param2' => 'parametro2'])
            <h1>Componente 2</h1> 
        @endcomponent 

o `@componente` aceita dois argumentos, sendo o segundo opcional, o primeiro é o arquivo blade com o componente a ser carregado, no caso o componente funciona de maneira oposta ao do `@section`, no `@section` o arquivo se injeta dentro do arquivo que foi chamado pelo `@extends`, no caso o componente importa e carrega o arquivo dentro daquele espaço aonde está marcado com o `@component` e esse arquivo a ser inserido ali deve ser informado no primeiro argumento, no segundo argumento você passa os valores a serem lidos no componente, repare que o *$param1* e o *$param2* é definido dentro de um array e que estaram disponíveis dentro do componente como valores [componente2.blade.php](./basico/resources/views/componentes/componente2.blade.php):

    <div>
        {{$slot}}    
        <hr>
        <ul>
            <li>{{$param1}}</li>
            <li>{{$param2}}</li>
        </ul>
        <hr>    
            <h3>Conteúdo de $slot</h3>   
            {{dd($slot)}}    
    </div>

Aqui temos o uso das variáveis `<li>{{$param1}}</li>` e `<li>{{$param2}}</li>`, ambas definidas aqui `@component('componentes.componente2',['param1' => 'Parametro1', 'param2' => 'parametro2'])`, agora essa parte aqui `{{$slot}}` vai renderizar o que está aqui `<h1>Componente 2</h1>`, no caso com a variável *$slot*, você implementa o corpo do que foi definido o componente, tudo que foi definido no corpo pode ser impresso na integra, através da variável *$slot*.

##### $loop dos laços no Laravel
    <div>
        {{$slot}}
        @php
            $arr = [0,1,2,3,4,5,6,7,8,9];    
        @endphp

        @foreach ([1] as $item)
            <h3>Conteudo da $loop dentro de um array</h3>
        @dump($loop)
        @endforeach
    </div>

Todo o laço no laravel tem essa variável para que você possa fazer certas verificações, como exemplo do output do arquivo [componente1.blade.php](./basico/resources/views/componentes/componente1.blade.php) acima, abaixo a estrutura do `$loop`.

    +"iteration": 1
    +"index": 0
    +"remaining": 0
    +"count": 1
    +"first": true
    +"last": true
    +"odd": true
    +"even": false
    +"depth": 1
    +"parent": null

O `+` indica que o atributo é publico, esses atributos dizem sobre o array, o *iteration* diz qual é o turno, se for a primeira vez que executa é 1, se for a segunda é dois e por ai vai, interessante para criar listas, pois começa do 1 e não do zero como o *index* que justamente informa o índice do array. *remaining* quantos arrays faltam, *count* quantos elementos tem, *first* se é a primeira execução, assim como *last* que também retorna um booleano informando respectivamente se é o primeiro e o ultimo indice do array, o *odd* se o *iteration* é impar e o *even* se for par, interessante para criar listas zebradas, informando um plano de fundo para colunas pares e outro para impares se for o caso, o *depth* retorna a profundidade ou nível de aninhamento do loop atual; devolve 2 se for um ciclo dentro de outro e 3 se estiver aninhado um nível mais profundo, ou seja varredura de escala quadrática retorna 2, varredura de escala cúbica retorna 3 e por ai vai... *parent* Se este loop estiver aninhado em outro loop @foreach, parent retorna a variável de loop do pai; Se não for testado, retorna nulo. No caso esse seria interessante se em um laço de repetição de escala quadrática, cúbica ou etc... você quer acessar o laço imediatamente acima, por exemplo se você está em um laço cúbico e quer acessar o laço quadrático, logo você usa isso.

#### Como ficou as rotas até agora?

    +--------+----------------------------------------+-------------------------------+--------------------+---------------------------------------------+------------+
    | Domain | Method                                 | URI                           | Name               | Action                                      | Middleware |
    +--------+----------------------------------------+-------------------------------+--------------------+---------------------------------------------+------------+
    |        | GET|HEAD                               | /                             | index              | Closure                                     | web        |
    |        | GET|HEAD                               | api/index                     | nomedarota         | Closure                                     | api        |
    |        | GET|HEAD                               | api/redirecionar              |                    | Closure                                     | api        |
    |        | GET|HEAD|POST|PUT|PATCH|DELETE|OPTIONS | api/redirect                  |                    | Illuminate\Routing\RedirectController       | api        |
    |        | POST                                   | api/test                      |                    | Closure                                     | api        |
    |        | PUT                                    | api/test                      |                    | Closure                                     | api        |
    |        | PATCH                                  | api/test                      |                    | Closure                                     | api        |
    |        | DELETE                                 | api/test                      |                    | Closure                                     | api        |
    |        | GET|HEAD                               | api/test                      |                    | Closure                                     | api        |
    |        | GET|HEAD                               | api/user                      |                    | Closure                                     | api        |
    |        |                                        |                               |                    |                                             | auth:api   |
    |        | POST                                   | controller                    | controller.store   | App\Http\Controllers\resource@store         | web        |
    |        | GET|HEAD                               | controller                    | controller.index   | App\Http\Controllers\resource@index         | web        |
    |        | GET|HEAD                               | controller/create             | controller.create  | App\Http\Controllers\resource@create        | web        |
    |        | DELETE                                 | controller/{controller}       | controller.destroy | App\Http\Controllers\resource@destroy       | web        |
    |        | PUT|PATCH                              | controller/{controller}       | controller.update  | App\Http\Controllers\resource@update        | web        |
    |        | GET|HEAD                               | controller/{controller}       | controller.show    | App\Http\Controllers\resource@show          | web        |
    |        | GET|HEAD                               | controller/{controller}/edit  | controller.edit    | App\Http\Controllers\resource@edit          | web        |
    |        | GET|HEAD                               | exemplo/{n1}/{n2}             |                    | App\Http\Controllers\classe@metodo          | web        |
    |        | GET|HEAD                               | numero/{n}                    |                    | Closure                                     | web        |
    |        | GET|HEAD                               | rotaexemplo                   |                    | Closure                                     | web        |
    |        | GET|HEAD                               | rotaexemplo/{param1?}         |                    | Closure                                     | web        |
    |        | GET|HEAD                               | rotaexemplo/{param1}/{param2} |                    | Closure                                     | web        |
    |        | GET|HEAD                               | route                         |                    | Closure                                     | web        |
    |        | GET|HEAD                               | route/{nome}/{repetir?}       |                    | Closure                                     | web        |
    |        | GET|HEAD                               | view                          |                    | App\Http\Controllers\view@template          | web        |
    |        | GET|HEAD                               | view/{n}                      |                    | App\Http\Controllers\view@view_simples      | web        |
    |        | GET|HEAD                               | view_avancado/{n?}            | avancado           | App\Http\Controllers\view_avancado@response | web        |
    +--------+----------------------------------------+-------------------------------+--------------------+---------------------------------------------+------------+

### Migrate 

[arquivo](./basico/database/migrations/2020_12_04_152328_exemplo1.php)

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class Exemplo1 extends Migration
    {
        /**
        * Execute as migrações.
        *
        * @return void
        */
        public function up()
        {
            Schema::create('exemplo1', function (Blueprint $table) {
                $table->id();
                $table->string('Valor')->unique();
                $table->double('numero');
                $table->date('data')->nullable();
                $table->boolean('check')->default(true);
                $table->rememberToken();
                $table->timestamps();
            });            

        }

        /**
        * Reverta as migrações.
        *
        * @return void
        */
        public function down()
        {
            Schema::dropIfExists('exemplo1');
        }
    }

#### public function up() e public function down()
As migrations tem por objetivo automatizar e gerenciar as estruturas dos banco de dados, no caso é criado a função **UP** é executada na criação de tabelas e o **DOWN** caso seja necessário dar um rollback, sempre recomenda-se programar as duas funções e caso seja necessário dar um rollback e voltar a ultima estrutura consolidade, volta-se através da função **DOWN**, pense nas migrations como uma espécie de *"GIT"* para banco de dados.

#### Schema::create e Schema::dropIfExists
Essa função `Schema::create('exemplo1', function (Blueprint $table) ` cria tabelas no banco de dados, sendo a sua versão destrutora de tabelas `Schema::dropIfExists('exemplo1')`, lembrando que o `'exemplo1'` deve ser substituído pelo nome da tabela, isso serve para o único parametro do `Schema::dropIfExists` assim como o primeiro parametro de `Schema::create`. O segundo parametro da função de criação é uma callback que irá construir a tabela no banco de dados. Cuidado ao renomear as tabelas, existe um sistema de nomenclatura no laravel, que uma vez que seja respeitado, facilita e muito a integração e reduz a significativamente muitas configurações, caso a nomenclatura seja respeitada, no caso usar o nome das tabelas no plural é uma delas, isso ajuda muito na integração com o Laravel, ignorar essa convenção pode exigir configurações extras por parte do Laravel para identificar a tabela no SGBD.

##### function (Blueprint $table)
Esse objeto do tipo `Blueprint` tem os seguintes métodos:

`$table->id()` => Gera um campo Primary Key para a tabela.

`$table->string('[Valor]')` => Cria um campo do tipo String na tabela, o `[Valor]` deve ser substituido pelo nome do campo.

`$table->string('[Valor]')->unique()` => Quando adicionado o metodo do unique, isso indica que o valor do campo `[Valor]` deve ser único na tabela.

`$table->double('[numero]')` => Cria um campo númerico para números com pontos flutuantes, o `[numero]` deve ser substituído pelo nome do campo.

`$table->date('[data]')` => cria um campo para datas dentro da tabela, `[data]` deve ser substiuído pelo nome da coluna.

`$table->date('[data]')->nullable()` => O método **nullable**, quando adicionado permite com que o campo aceite valores nulos.

`$table->boolean('[check]')` => O método boolean cria um campo booleano na tabela, deve-se substituir o `[check]` pelo nome da coluna.

`$table->boolean('check')->default(true)` => Quando adicionado o método **default**, você coloca um valor padrão para o campo, caso o mesmo não tenha um valor.

`$table->rememberToken()` => cria um campo para o gerenciamento de *tokens* na tabela. Pode ser útil caso queira usar essa tabela para gerenciar logins.

`$table->timestamps()` => cria dois campos do tipo **datastamp**, que contem adiciona dois campos, com a data de criação e outra com a data da ultima modificação, pode ser interessante, caso queira ter um controle sobre as alterações feita nas tabelas. 
#### Chaves Estrangeiras

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class Exemplo2 extends Migration
    {

        public function up()
        {
            Schema::create('exemplo2', function (Blueprint $table) {                                  
                $table->bigIncrements('id');
                $table->foreignId('fk');

                $table
                ->foreign('fk')
                ->references('id')
                ->on('exemplo1')
                ->onUpdate('cascade')
                ->onDelete('cascade');

                $table->timestamps();
            });
        }

        
        public function down()
        {
            Schema::table('exemplo2', function (Blueprint $table) {
                $table->dropForeign(['fk']);
            });
            Schema::drop('exemplo2');
        }
    }

##### bigIncrements('[id]')
Esse método na prática faz o que o método `id('id)` faz, no caso o *id* é um alias para esse. Substitua o `[id]` pelo nome da coluna de id, ou deixe em branco que será usado id na ausência de parametro no método.

#### foreignId('[fk]')
Cria uma chave estrangeira, ou seja informa ao Laravel que essa tabela vai ter uma chave estrangeira. Substitua o `[fk]` pelo correspondente ao nome da coluna aonde estará a chave estrangeira.

##### criando a chave estrageira
Além de informar o `foreignId`, você deve setar algumas configurações:

        $table
            ->foreign('fk')
            ->references('id')
            ->on('exemplo')
            ->onUpdate('cascade')
            ->onDelete('cascade');

`->foreign('[fk]')` aqui em `[fk]` deve ser informado o nome do campo correspondente da chave estrangeira na tabela que possui a chave estrangeira, `->references('[id]')`, aqui aonde está `[id]` deve ser informado o campo na outra tabela, ao qual a chave estrangeira faz referencia, nesse caso o nome do campo da outra tabela, `->on('[exemplo1]')`, aonde está exemplo você deve informar o nome da outra tabela ao qual essa **fk** se relaciona.

#### ->onUpdate('cascade'), onDelete('cascade')
Ambos os métodos são opcionais, no caso seria possível criar uma fk apenas com:

        $table
            ->foreign('fk')
            ->references('id')
            ->on('exemplo1');

No caso estamos definindo o estilo *cascade* para a exclusão e atualização, nos métodos se faz necessário informar em formato de sting estaram conectados, no caso se apagar ou atualizar qualquer valor nessa fk, isso será refletido do outro lado, cascade é muito perigoso de usar para exclusões, pois ao excluir na fk toda as referencias serão apagadas.

### Model
[Collections 'documentação'](https://laravel.com/docs/8.x/collections#available-methods) o tipo de dado que essas operações retornam, é um objeto que aceita vários tipos de operações e algumas explicadas aqui.

[Builder 'documentação'](https://laravel.com/docs/8.x/queries), aqui o outro tipo muito importante para a construção de Query complexas.
### Método estático all()

Uma vez acessado, você pode usar o método estático all para acessar todos os registros no banco de dados desse modelo como no exemplo `[Modelo]::all()`, lembrando que o `[Modelo]` deve ser substituído pelo Modelo: `Modelo::all()`, lembrando que por padrão um model chamado de `Model` procuraria por um banco de dados chamado `models`, por padrão, logo esse seria um dos motivos para uma Migration estar no plural e o Modelo em upperlowercase e no singular. O que esse método faz `Modelo::all()` é justamente um fullscan no banco de dados, no caso o famoso `select *`, que pode derrubar um banco de dados em modo produção, se houver um retorno parecido com isso:

    => Illuminate\Database\Eloquent\Collection {#4212
     all: [],
    }

Significa que não há dados registrados.

#### Inserindo dados
    $modelo = new Modelo();
    $modelo->valor = 'valor1';
    $modelo->numero = 1000;

No caso você instancia o Modelo e coloca valor em todos os seus atributos, no caso [essa migration](./basico/database/migrations/2020_12_05_155827_modelos.php) tem apenas dois dados obrigatórios que são esses dois. Nessa estratégia você instancia o Modelo, coloca atributos neles, seguindo a logica do método mágico `__set`e uma vez que tudo esteja feito:

     $modelo->save()

O método `save()` vem da classe pai do modelo a `Illuminate\Database\Eloquent\Model` e esse método salva os dados que você colocou, se tudo ocorrer bem o output será esse:

    => true
Usando o método `$modelo->all()` ou `Model::all()`, sendo o output:

    => Illuminate\Database\Eloquent\Collection {#4213
     all: [
       App\Models\Modelo {#4214
         id: 1,
         Valor: "valor1",
         numero: 1000.0,
         data: null,
         check: 1,
         remember_token: null,
         created_at: "2020-12-05 17:12:13",
         updated_at: "2020-12-05 17:12:13",
       },
     ],

##### Usando o método estático create
     Modelo::create(['valor' => 'Valor', 'numero' => '0'])

Esse método acima você usa o `::create()`, dentro desse método você passa um array associativo, sendo chave o campo e o valor o valor a ser inserido, porém o mesmo deve ser informado na classe de [Modelo](./basico/app/Models/Modelo.php), do contrário o erro abaixo acontece:

    PHP Fatal error:  Class 'Modelo' not found in Psy Shell code on line 1

No caso acima se faz necessário fazer uns ajustes na classe [Modelo](./basico/app/Models/Modelo.php), no caso informar os campos a propriedade protegida `protected $fillable = ['valor','numero']`:

    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Modelo extends Model
    {
        use HasFactory;
        protected $fillable = ['valor','numero'];
    }

Ali dentro do array `$fillable` deve conter pelo menos o nome de todos os campos da tabela ao qual você deseja inserir valores, e lembrando que o array a ser passado como parametro em `Modelo::create(['valor' => 'Valor', 'numero' => '0'])` deve seguir a mesma ordem que a definida no `$fillable`, nesse exemplo é aceito respectivamente uma String e um Double, sendo o output do comando `Modelo::create(['valor' => 'valor','numero' => '990'])`:

    => App\Models\Modelo {#4200
            valor: "valor",
            numero: "990",
            updated_at: "2020-12-05 17:40:21",
            created_at: "2020-12-05 17:40:21",
            id: 2,
        }

#### Procurando dados
##### usando o método estático Find

        Illuminate\Database\Eloquent\Collection {#4234
        all: [
            App\Models\Modelo {#4238
                id: 1,
                Valor: "valor1",
                numero: 1000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 17:12:13",
                updated_at: "2020-12-05 17:12:13",
            },
            App\Models\Modelo {#4242
                id: 2,
                Valor: "valor",
                numero: 990.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 17:40:21",
                updated_at: "2020-12-05 17:40:21",
            },
            App\Models\Modelo {#4243
                id: 3,
                Valor: "meu valor",
                numero: 500.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 18:44:45",
                updated_at: "2020-12-05 18:44:45",
            },
            App\Models\Modelo {#4244
                id: 4,
                Valor: "meu_valor",
                numero: 850.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 18:44:56",
                updated_at: "2020-12-05 18:44:56",
            },
            App\Models\Modelo {#4245
                id: 5,
                Valor: "m_val",
                numero: 335.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 18:45:11",
                updated_at: "2020-12-05 18:45:11",
            },
        ],
    }
    

Com o find você pode retornar registros com base no ID, no caso para que isso ocorra você deve definir o nome como `ID` na sua Migration, uma vez feito isso você pode usar esse método, ou seja ele retorna o valor passado como, o exemplo abaixo seria algo como `select * from [modelos] where id = 3`, sendo `[modelos]` o nome da tabela desse exemplo, seguindo o padrão de nomenclatura do Laravel: Comando no *tinker* `Modelo::find(3)`:

    => App\Models\Modelo {#4215
            id: 3,
            Valor: "meu valor",
            numero: 500.0,
            data: null,
            check: 1,
            remember_token: null,
            created_at: "2020-12-05 18:44:45",
            updated_at: "2020-12-05 18:44:45",
        }

Comando no tinker `Modelo::find([3,5])`, algo equivalente a `select * from [modelos] where id = 3 or id = 5`, no caso o array funciona como um conjunto de **or**.

    => Illuminate\Database\Eloquent\Collection {#4204
        all: [
            App\Models\Modelo {#4210
                id: 3,
                Valor: "meu valor",
                numero: 500.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 18:44:45",
                updated_at: "2020-12-05 18:44:45",
            },
            App\Models\Modelo {#4223
                id: 5,
                Valor: "m_val",
                numero: 335.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 18:45:11",
                updated_at: "2020-12-05 18:45:11",
            },
        ],
    }

Comando no tinker `Modelo::find(4,['id','valor','numero'])`, seria equivalente a `select id,valor,numero from [modelos] where id = 4`, caso os elementos do array passado como segundo parametro, passado em formato string, os parametros são usados como base para retornar as colunas, segue o exemplo passando como segundo parametro um array de String.

        => App\Models\Modelo {#4215
            id: 4,
            valor: "meu_valor",
            numero: 850.0,
        }

Passando dois arrays para o método find: `Modelo::find([2,4],['id','valor','numero'])`, seria equivalente a `select id, valor, numero [modelos] where id = 2 or id =4`

        => Illuminate\Database\Eloquent\Collection {#4223
            all: [
                App\Models\Modelo {#4221
                    id: 2,
                    valor: "valor",
                    numero: 990.0,
                },
                App\Models\Modelo {#4233
                    id: 4,
                    valor: "meu_valor",
                    numero: 850.0,
                },
            ],
    }

Lembrando: O primeiro parametro sempre será ou o *ID*, ou um array contendo *IDS* a serem retornados e o segundo deve ser uma String ou uma array de string com os campos a serem retornados pelo o método *::find*, mas novamente você deve ter a primary key nomeada como id na sua tabela, do contrário esse método não funcionará.

##### Where
Exemplo de `Modelo::where('id',3)`, nesse caso esse método retorna um objeto, segue o output: `=> Illuminate\Database\Eloquent\Builder {#4241}`, ou seja com o where é possível fazer uma sequência customizável de consultas.

##### Método get() do where
Se você quer usar de maneira semelhante ao `::find()`, você deve informar o `->get()` após o `where()`, ficando `::where()->get()`, exemplo: `Modelo::where('id',3)->get()` sendo equivalente a `select * from modelos where id = 3`, output:

        => Illuminate\Database\Eloquent\Collection {#4201
            all: [
                App\Models\Modelo {#4237
                    id: 3,
                    Valor: "meu valor",
                    numero: 500.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:45",
                    updated_at: "2020-12-05 18:44:45",
                },
            ],
        }

o `::where` é a alternativa ao find e permite passar o nome do campo que deseja-se buscar, no caso pode-se fazer consultas em campos que não seja id ` Modelo::where('numero',500)->get()`, sendo: `select * from modelos where numero = 500`

        => Illuminate\Database\Eloquent\Collection {#4229
            all: [
                App\Models\Modelo {#4209
                    id: 3,
                    Valor: "meu valor",
                    numero: 500.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:45",
                    updated_at: "2020-12-05 18:44:45",
                },
            ],
        }

Também é possível encadear where `::where()->where()->where()`, nesse caso o operador funciona como um **AND** `Modelo::where('numero',500)->where('id',3)->get()` equivalente a `select * from modelos where numero = 500 and id = 3`:

        => Illuminate\Database\Eloquent\Collection {#4244
            all: [
                App\Models\Modelo {#4229
                    id: 3,
                    Valor: "meu valor",
                    numero: 500.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:45",
                    updated_at: "2020-12-05 18:44:45",
                },
            ],
        }

Lembre-se que apenas o primeiro **where** é estático, os outros não são, logo: `::where()->where()->where()->where() ... ->get()`, porém para ter retorno deve-se usar o `get()`, pois até que isso aconeteça o retorno será um objeto `Illuminate\Database\Eloquent\Builder`.

##### Terceiro parametro no where
Quando você quer que o operador do where seja diferente do igual, você deve informar isso como segundo parametro do where, exemplo: `Modelo::where('id','>',1)->where('id','<',5)->get()`, que equivale a: `select * from modelos where id > 1 and id < 5`. Output:

        => Illuminate\Database\Eloquent\Collection {#4231
            all: [
                App\Models\Modelo {#4242
                    id: 2,
                    Valor: "valor",
                    numero: 990.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 17:40:21",
                    updated_at: "2020-12-05 17:40:21",
                },
                App\Models\Modelo {#4224
                    id: 3,
                    Valor: "meu valor",
                    numero: 500.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:45",
                    updated_at: "2020-12-05 18:44:45",
                },
                App\Models\Modelo {#4204
                    id: 4,
                    Valor: "meu_valor",
                    numero: 850.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:56",
                    updated_at: "2020-12-05 18:44:56",
                },
            ],
        }

Ou seja um *where* com dois parametros ele procura por valores que são iguais aos passados, porém quando tem três parametros, esse relacionamento seria determinado pelo segundo parametro.

##### orWhere
`Modelo::orWhere('id','=','2')->orWhere('id','=','4')->get()` que seria equivalente a `select * from modelos where id = 2 or id = 4`, por padrão o **where** trabalha com o operador *AND* para cada where, caso seja necessário ao invés de usar o *AND* usar o *OR*, logo tem o **orWhere**.

    => Illuminate\Database\Eloquent\Collection {#4238
        all: [
            App\Models\Modelo {#4239
                id: 2,
                Valor: "valor",
                numero: 990.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 17:40:21",
                updated_at: "2020-12-05 17:40:21",
            },
            App\Models\Modelo {#4240
                id: 4,
                Valor: "meu_valor",
                numero: 850.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 18:44:56",
                updated_at: "2020-12-05 18:44:56",
            },
        ],
    }

##### whereBetween
`whereBetween` procura um intervalo de valores, essa query `Modelo::whereBetween('id',[1,3])->get()` seria equivalente a `SELECT * FROM modelos WHERE id BETWEEN 1 and 3`, o primeiro valor é o campo e o segundo um array contendo um intervalo a ser analisado, como no exemplo abaixo:

    => Illuminate\Database\Eloquent\Collection {#4202
        all: [
            App\Models\Modelo {#4213
                id: 1,
                Valor: "valor1",
                numero: 1000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 17:12:13",
                updated_at: "2020-12-05 17:12:13",
            },
            App\Models\Modelo {#4237
                id: 2,
                Valor: "valor",
                numero: 990.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 17:40:21",
                updated_at: "2020-12-05 17:40:21",
            },
            App\Models\Modelo {#4229
                id: 3,
                Valor: "meu valor",
                numero: 500.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-05 18:44:45",
                updated_at: "2020-12-05 18:44:45",
            },
        ],
    }

##### whereNotBetween
Faz o exato contrário do whereNotBetween, ou seja ele seleciona tudo que estiver fora da seleção do **whereBetween**. Isso ` Modelo::whereNotBetween('id',[1,3])->get()` seria equivalente a `SELECT * FROM `modelos` WHERE id NOT BETWEEN 1 and 3`. Output:

        => Illuminate\Database\Eloquent\Collection {#4223
            all: [
                App\Models\Modelo {#4238
                    id: 4,
                    Valor: "meu_valor",
                    numero: 850.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:56",
                    updated_at: "2020-12-05 18:44:56",
                },
                App\Models\Modelo {#4220
                    id: 5,
                    Valor: "m_val",
                    numero: 335.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:45:11",
                    updated_at: "2020-12-05 18:45:11",
                },
            ],
    }

##### WhereIn e WhereNotIn
WhereIn seleciona dentro de um intervalo e o whereNotIn fora desse intervalo especificado, esse código ` Modelo::whereIn('id',[1,3,5])->get()` equivale a `SELECT * FROM `modelos` WHERE id IN (1,3,5)`, ou seja retorna o valor dentro do intervalo especificado. Output:

        => Illuminate\Database\Eloquent\Collection {#4250
            all: [
                App\Models\Modelo {#4227
                    id: 1,
                    Valor: "valor1",
                    numero: 1000.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 17:12:13",
                    updated_at: "2020-12-05 17:12:13",
                },
                App\Models\Modelo {#4200
                    id: 3,
                    Valor: "meu valor",
                    numero: 500.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:45",
                    updated_at: "2020-12-05 18:44:45",
                },
                App\Models\Modelo {#4248
                    id: 5,
                    Valor: "m_val",
                    numero: 335.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:45:11",
                    updated_at: "2020-12-05 18:45:11",
                },
            ],
        }

A negação com o **whereNotBetween** ` Modelo::whereNotIn('id',[1,3,5])->get()` equivale a `SELECT * FROM `modelos` WHERE id NOT IN (1,3,5)`, output:

        => Illuminate\Database\Eloquent\Collection {#4221
            all: [
                App\Models\Modelo {#4213
                    id: 2,
                    Valor: "valor",
                    numero: 990.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 17:40:21",
                    updated_at: "2020-12-05 17:40:21",
                },
                App\Models\Modelo {#4219
                    id: 4,
                    Valor: "meu_valor",
                    numero: 850.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:56",
                    updated_at: "2020-12-05 18:44:56",
                },
            ],
        }

##### Função dentro do Where
Você também pode passar callbacks para consultas SQL mais avançadas, exemplo ` Modelo::where(function($sql){ $sql->where('id',2);})->get()`:

        => Illuminate\Database\Eloquent\Collection {#4220
            all: [
                App\Models\Modelo {#4202
                    id: 2,
                    Valor: "valor",
                    numero: 990.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 17:40:21",
                    updated_at: "2020-12-05 17:40:21",
                },
            ],
    }

Também é possível passar callback para o orWhere `Modelo::orWhere(function($sql){$sql->where('id',2)->orWhere('id','>',3);})->get()`, no caso essas servem para fazer consultas mais complexas:

        => Illuminate\Database\Eloquent\Collection {#4223
            all: [
                App\Models\Modelo {#4229
                    id: 2,
                    Valor: "valor",
                    numero: 990.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 17:40:21",
                    updated_at: "2020-12-05 17:40:21",
                },
                App\Models\Modelo {#4230
                    id: 4,
                    Valor: "meu_valor",
                    numero: 850.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:44:56",
                    updated_at: "2020-12-05 18:44:56",
                },
                App\Models\Modelo {#4231
                    id: 5,
                    Valor: "m_val",
                    numero: 335.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-05 18:45:11",
                    updated_at: "2020-12-05 18:45:11",
                },
            ],
    }

#### Métodos ùteis
##### toArray
Esse método converte o resultado em array, exemplo ` Modelo::all()->toArray()`, saida:

        => [
            [
                "id" => 1,
                "Valor" => "valor1",
                "numero" => 1000.0,
                "data" => null,
                "check" => 1,
                "remember_token" => null,
                "created_at" => "2020-12-05T17:12:13.000000Z",
                "updated_at" => "2020-12-05T17:12:13.000000Z",
            ],
            [
                "id" => 2,
                "Valor" => "valor",
                "numero" => 990.0,
                "data" => null,
                "check" => 1,
                "remember_token" => null,
                "created_at" => "2020-12-05T17:40:21.000000Z",
                "updated_at" => "2020-12-05T17:40:21.000000Z",
            ],
            [
                "id" => 3,
                "Valor" => "meu valor",
                "numero" => 500.0,
                "data" => null,
                "check" => 1,
                "remember_token" => null,
                "created_at" => "2020-12-05T18:44:45.000000Z",
                "updated_at" => "2020-12-05T18:44:45.000000Z",
            ],
            [
                "id" => 4,
                "Valor" => "meu_valor",
                "numero" => 850.0,
                "data" => null,
                "check" => 1,
                "remember_token" => null,
                "created_at" => "2020-12-05T18:44:56.000000Z",
                "updated_at" => "2020-12-05T18:44:56.000000Z",
            ],
            [
                "id" => 5,
                "Valor" => "m_val",
                "numero" => 335.0,
                "data" => null,
                "check" => 1,
                "remember_token" => null,
                "created_at" => "2020-12-05T18:45:11.000000Z",
                "updated_at" => "2020-12-05T18:45:11.000000Z",
            ],
        ]

##### toJson

Converte a saída para JSON `Modelo::all()->tojson()`:

    => "[{"id":1,"Valor":"valor1","numero":1000,"data":null,"check":1,"remember_token":null,"created_at":"2020-12-05T17:12:13.000000Z","updated_at":"2020-12-05T17:12:13.000000Z"},{"id":2,"Valor":"valor","numero":990,"data":null,"check":1,"remember_token":null,"created_at":"2020-12-05T17:40:21.000000Z","updated_at":"2020-12-05T17:40:21.000000Z"},{"id":3,"Valor":"meu
    valor","numero":500,"data":null,"check":1,"remember_token":null,"created_at":"2020-12-05T18:44:45.000000Z","updated_at":"2020-12-05T18:44:45.000000Z"},{"id":4,"Valor":"meu_valor","numero":850,"data":null,"check":1,"remember_token":null,"created_at":"2020-12-05T18:44:56.000000Z","updated_at":"2020-12-05T18:44:56.000000Z"},{"id":5,"Valor":"m_val","numero":335,"d
    ata":null,"check":1,"remember_token":null,"created_at":"2020-12-05T18:45:11.000000Z","updated_at":"2020-12-05T18:45:11.000000Z"}]"

##### Chunk
O método `chunk` cria uma separação entre os elementos, facilitando a paginação e a distribuição em colunas, por exemplo se for passado o número *2* de parametro e tem 6 registros, será criado 3 divisões interna, cada um com duas ocorrências, exemplo: ` Modelo::all()->chunk(2)`:

        => Illuminate\Database\Eloquent\Collection {#4222
            all: [
            Illuminate\Database\Eloquent\Collection {#4248
                all: [
                    App\Models\Modelo {#4239
                        id: 1,
                        Valor: "valor1",
                        numero: 1000.0,
                        data: null,
                        check: 1,
                        remember_token: null,
                        created_at: "2020-12-05 17:12:13",
                        updated_at: "2020-12-05 17:12:13",
                    },
                    App\Models\Modelo {#4238
                        id: 2,
                        Valor: "valor",
                        numero: 990.0,
                        data: null,
                        check: 1,
                        remember_token: null,
                        created_at: "2020-12-05 17:40:21",
                        updated_at: "2020-12-05 17:40:21",
                    },
                ],
            },
            Illuminate\Database\Eloquent\Collection {#4240
                all: [
                    2 => App\Models\Modelo {#4245
                            id: 3,
                            Valor: "meu valor",
                            numero: 500.0,
                            data: null,
                            check: 1,
                            remember_token: null,
                            created_at: "2020-12-05 18:44:45",
                            updated_at: "2020-12-05 18:44:45",
                    },
                    3 => App\Models\Modelo {#4241
                            id: 4,
                            Valor: "meu_valor",
                            numero: 850.0,
                            data: null,
                            check: 1,
                            remember_token: null,
                            created_at: "2020-12-05 18:44:56",
                            updated_at: "2020-12-05 18:44:56",
                    },
                ],
            },
            Illuminate\Database\Eloquent\Collection {#4235
                all: [
                    4 => App\Models\Modelo {#4255
                        id: 5,
                        Valor: "m_val",
                        numero: 335.0,
                        data: null,
                        check: 1,
                        remember_token: null,
                        created_at: "2020-12-05 18:45:11",
                        updated_at: "2020-12-05 18:45:11",
                    },
                ],
            },
            ],
    }

##### Pluck
Essa função retorna apenas o campo selecionado: `Modelo::all()->pluck('numero')`, esse campo deve estar registrado em `protected $fillable = ['valor','numero'];` no arquivo models.

    => Illuminate\Support\Collection {#4238
        all: [
            1000.0,
            990.0,
            500.0,
            850.0,
            335.0,
        ],
    }

#### Atualizando registros
##### Método estático
No caso usa-se a clausuraa where para pegar o registro e depois disso passa um array ao método update no estilo chave e valor, com o nome da coluna sendo a chave e o novo valor dela, exemplo: `>>> Modelo::where('id',3)->update(['numero' => 750])` que equivale a `update from modelos set numero = 750 where id = 3`

    >>> Modelo::where('id',3)->update(['numero' => 750])
    => 1

Se der certo retorna a quantidade de registros afetados.
##### Método de Objeto.
    >>> $modelo = Modelo::find(3)
        => App\Models\Modelo {#4276
            id: 3,
            Valor: "meu valor",
            numero: 750.0,
            data: null,
            check: 1,
            remember_token: null,
            created_at: "2020-12-05 18:44:45",
            updated_at: "2020-12-07 21:57:56",
    }


    >>> $modelo->valor = 'valor mudado'
    => "valor mudado"
    >>> $modelo->save()
    => true
    >>> $modelo
    => App\Models\Modelo {#4276
            id: 3,
            Valor: "meu valor",
            numero: 750.0,
            data: null,
            check: 1,
            remember_token: null,
            created_at: "2020-12-05 18:44:45",
            updated_at: "2020-12-07 22:16:27",
            valor: "valor mudado",
    }

Inicialmente pega-se o valor e armazena em uma váriável `$modelo = Modelo::find(3)`, no php existe o método `__set`, ou seja um método mágico *SET* e com base nisso você armazena o novo valor em um atributo mágico criado com o `__set` `$modelo->valor = 'valor mudado'`, `$modelo->valor` passou a existir agora, após feito isso basta salvar `$modelo->save()`, para que as informações seja persistidas.

#### Excluíndo registros
##### Método Estático
Você conseguir isso ` Modelo::destroy([id])`, caso você siga as convenções do Laravel, você pode passar o id que quer excluir no método destroy, `Modelo::destroy(1)` equivalente a `delete from models where id = 1`. Output:

    >>> Modelo::destroy(1)
    => 1

##### Método de objetos

    $modelo = Modelo::find(4)
    => App\Models\Modelo {#4220
        id: 4,
        Valor: "meu_valor",
        numero: 850.0,
        data: null,
        check: 1,
        remember_token: null,
        created_at: "2020-12-05 18:44:56",
        updated_at: "2020-12-05 18:44:56",
    }

    >>> $modelo->delete()
    => true

Para excluir, você pode resgatar o atributo e armazenar em variáveis `$modelo = Modelo::find(4)` e depois nessa variável `$modelo->delete()`, pronto excluído.

#### Soft Delete no Laravel.
Inicialmente você precisa importar uma trait:

    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Modelo extends Model
    {
        use HasFactory;
        use SoftDeletes;
        protected $fillable = ['valor','numero'];
    }

e na migrations você deve usar o método `->softDeletes()` para que seja criado o campo `deleted_at` no banco de dados, nesse caso se esse campo for nulo, significa que o dado não foi excluído e será registrado no método `::all()` ou em qualer método que recupere registros do banco de dados, porém quando uma data está registrado ali, logo isso significa que o dado foi excluído, porém tem como recuperar um dado excluído por softdelete ou até mesmo acessar os dados excluídos.

    class Modelos extends Migration
    {
        public function up()
        {
            Schema::create('modelos', function (Blueprint $table) {
                $table->id();
                $table->string('Valor')->unique();
                $table->double('numero');
                $table->date('data')->nullable();
                $table->boolean('check')->default(true);
                $table->rememberToken();
                $table->timestamps();
                
                //Metodo de softdownload
                $table->softDeletes();
            });   
        }

##### Todos os dados

        => Illuminate\Database\Eloquent\Collection {#4246
        all: [
            App\Models\Modelo {#4250
                id: 1,
                Valor: "valor1",
                numero: 1000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:51:57",
                updated_at: "2020-12-09 02:51:57",
                deleted_at: null,
            },
            App\Models\Modelo {#4253
                id: 2,
                Valor: "valor2",
                numero: 2000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:52:04",
                updated_at: "2020-12-09 02:52:04",
                deleted_at: null,
            },
            App\Models\Modelo {#4252
                id: 3,
                Valor: "valor3",
                numero: 3000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:52:10",
                updated_at: "2020-12-09 02:52:10",
                deleted_at: null,
            },
            App\Models\Modelo {#4251
                id: 4,
                Valor: "valor4",
                numero: 4000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 03:04:09",
                updated_at: "2020-12-09 03:04:09",
                deleted_at: null,
            },
            App\Models\Modelo {#4249
                id: 5,
                Valor: "valor5",
                numero: 5000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 03:04:15",
                updated_at: "2020-12-09 03:04:15",
                deleted_at: null,
            },
        ],
    }

Quando o update tem a mesma data que o create, isso significa que o dado não foi alterado depois de inserido, e todos os deletes estão marcados como Nulo, os comandos para exclusão são semelhantes ao método hardcode.[Metodos de exclusão](#excluíndo-registros)

##### Excluíndo com o método destroy
    >>> Modelo::destroy([2,4])
    => 2
    >>> Modelo::all()

o destroy aceita um array com uma séries de ID, uma vez feito isso, ao executar o comando `Modelo::all()`:

        => Illuminate\Database\Eloquent\Collection {#4221
        all: [
            App\Models\Modelo {#4216
                id: 1,
                Valor: "valor1",
                numero: 1000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:51:57",
                updated_at: "2020-12-09 02:51:57",
                deleted_at: null,
            },
            App\Models\Modelo {#4257
                id: 3,
                Valor: "valor3",
                numero: 3000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:52:10",
                updated_at: "2020-12-09 02:52:10",
                deleted_at: null,
            },
            App\Models\Modelo {#4212
                id: 5,
                Valor: "valor5",
                numero: 5000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 03:04:15",
                updated_at: "2020-12-09 03:04:15",
                deleted_at: null,
            },
        ],
    }

Repare que agora só será retornando registro com o `deleted_at = null`, ou seja ele fica inacessível com os métodos tradicionais, porém existe métodos para acessar dados excluídos por soft delete.

##### Retornando todos os valores inclusive os excluídos
Para tal você deve usar o método estático `::withTrashed()` ao invés do `::all()`, ficando assim:

    >>> Modelo::withTrashed()->get()
    => Illuminate\Database\Eloquent\Collection {#4265
        all: [
            App\Models\Modelo {#4266
                id: 1,
                Valor: "valor1",
                numero: 1000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:51:57",
                updated_at: "2020-12-09 02:51:57",
                deleted_at: null,
            },
            App\Models\Modelo {#4267
                id: 2,
                Valor: "valor2",
                numero: 2000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:52:04",
                updated_at: "2020-12-09 03:07:55",
                deleted_at: "2020-12-09 03:07:55",
            },
            App\Models\Modelo {#4268
                id: 3,
                Valor: "valor3",
                numero: 3000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:52:10",
                updated_at: "2020-12-09 02:52:10",
                deleted_at: null,
            },
            App\Models\Modelo {#4269
                id: 4,
                Valor: "valor4",
                numero: 4000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 03:04:09",
                updated_at: "2020-12-09 03:07:55",
                deleted_at: "2020-12-09 03:07:55",
            },
            App\Models\Modelo {#4270
                id: 5,
                Valor: "valor5",
                numero: 5000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 03:04:15",
                updated_at: "2020-12-09 03:04:15",
                deleted_at: null,
            },
        ],
    }

Repare que nos dados excluídos os campos excluídos possuem valor diferente de nulo em `deleted_at`, para recuperar basta mudar esse valor para nulo ou usar o método `restore`

##### Restaurando

    >>> Modelo::onlyTrashed()->restore()
    => 2
    >>> Modelo::all()
    => Illuminate\Database\Eloquent\Collection {#4275
        all: [
                App\Models\Modelo {#4228
                    id: 1,
                    Valor: "valor1",
                    numero: 1000.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-09 02:51:57",
                    updated_at: "2020-12-09 03:20:38",
                    deleted_at: null,
                },
                App\Models\Modelo {#4212
                    id: 2,
                    Valor: "valor2",
                    numero: 2000.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-09 02:52:04",
                    updated_at: "2020-12-09 03:37:58",
                    deleted_at: null,
                },
                App\Models\Modelo {#4277
                    id: 4,
                    Valor: "valor4",
                    numero: 4000.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-09 03:04:09",
                    updated_at: "2020-12-09 03:37:58",
                    deleted_at: null,
                },
            App\Models\Modelo {#4282
                id: 5,
                Valor: "valor5",
                numero: 5000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 03:04:15",
                updated_at: "2020-12-09 03:20:38",
                deleted_at: null,
            },
        ],
    }
    >>>

No caso, para restaurar um dado excluído por softdelete, você acessa todos os excluídos `Modelo::onlyTrashed()` e restaura todos usando o método `->restore()` no resultado, porém se você não quiser restaurar todos, você pode usar uma clausura `where` entre `onlyTrashed` e `restore`. Ao exemplo de `Modelo::onlyTrashed()->where(['id' => 4])->restore()` com o output abaixo.

    >>> Modelo::onlyTrashed()->where(['id' => 4])->restore()
    => 1
    >>> Modelo::all()
    => Illuminate\Database\Eloquent\Collection {#4297
        all: [
        App\Models\Modelo {#4256
            id: 1,
            Valor: "valor1",
            numero: 1000.0,
            data: null,
            check: 1,
            remember_token: null,
            created_at: "2020-12-09 02:51:57",
            updated_at: "2020-12-09 03:20:38",
            deleted_at: null,
        },
        App\Models\Modelo {#4294
            id: 4,
            Valor: "valor4",
            numero: 4000.0,
            data: null,
            check: 1,
            remember_token: null,
            created_at: "2020-12-09 03:04:09",
            updated_at: "2020-12-09 03:43:41",
            deleted_at: null,
        },
        ],
    }
    >>>

##### onlyTrashed

    >>> Modelo::onlyTrashed()->get()
        => Illuminate\Database\Eloquent\Collection {#4225
            all: [
                App\Models\Modelo {#4228
                    id: 2,
                    Valor: "valor2",
                    numero: 2000.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-09 02:52:04",
                    updated_at: "2020-12-09 03:24:37",
                    deleted_at: "2020-12-09 03:24:37",
                },
                App\Models\Modelo {#4255
                    id: 4,
                    Valor: "valor4",
                    numero: 4000.0,
                    data: null,
                    check: 1,
                    remember_token: null,
                    created_at: "2020-12-09 03:04:09",
                    updated_at: "2020-12-09 03:24:37",
                    deleted_at: "2020-12-09 03:24:37",
                },
            ],
        }
    >>>

Use o método `onlyTrashed` no lugar do método `::all()` e por fim o `get` se quiser ter acesso aos registros, ao exemplo de `Modelo::onlyTrashed()->get()`.

##### Excluído do banco de dados
Para excluir do banco de dados usa-se o `forceDelete()`, com esse método se faz a exclusão de maneira hard.

    >>> Modelo::find(3)->forceDelete()
    => true
    >>> Modelo::all()
    => Illuminate\Database\Eloquent\Collection {#4276
        all: [
            App\Models\Modelo {#4277
                id: 1,
                Valor: "valor1",
                numero: 1000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:51:57",
                updated_at: "2020-12-09 03:20:38",
                deleted_at: null,
            },
            App\Models\Modelo {#4278
                id: 5,
                Valor: "valor5",
                numero: 5000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 03:04:15",
                updated_at: "2020-12-09 03:20:38",
                deleted_at: null,
            },
        ],
    }
    >>> Modelo::onlyTrashed()
    => Illuminate\Database\Eloquent\Builder {#4261}
    >>> Modelo::onlyTrashed()->get()
    => Illuminate\Database\Eloquent\Collection {#4283
        all: [
            App\Models\Modelo {#4284
                id: 2,
                Valor: "valor2",
                numero: 2000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 02:52:04",
                updated_at: "2020-12-09 03:24:37",
                deleted_at: "2020-12-09 03:24:37",
            },
            App\Models\Modelo {#4285
                id: 4,
                Valor: "valor4",
                numero: 4000.0,
                data: null,
                check: 1,
                remember_token: null,
                created_at: "2020-12-09 03:04:09",
                updated_at: "2020-12-09 03:24:37",
                deleted_at: "2020-12-09 03:24:37",
            },
        ],
    }
    >>>

Graças ao `Modelo::find(3)->forceDelete()` o registro se quer existe no banco de dados mais, no caso o `forceDelete` é um método de objeto e não de classe, além disso você obte-lo através do *find* ou *where*.

##### Sabendo se um dado foi excluído

    Modelo::find(5)->trashed()

 Uma vez pego o registro por *find* ou *where*, você pode através de um booleano saber se o registro está ou não excluído, no caso o método de objeto *trashed*



## Artisan

### Executando um projeto no laravel
    php artisan serve
### Exibindo listas de todas as rotas
    php artisan route:list

### Criando um controller
    php artisan make:controller [classe]

O `[classe]` deve ser substituído pela classe correspondente.

#### Criando um controller usando o parametro --resource
    php artisan make:controller [classe] --resource

Quando informado o `--resource` alguns métodos são criados.

### Models
Criando um modelo `php artisan make:model [Nome]`, dessa forma você cria um modelo, devendo substituir o `[Nome]` pelo nome correspondente ao da classe, como é classe recomenda-se que a primeira letra do nome comece com letra maiúscula e seja no singular, no caso uma classe que se chama **Modelo** por padrão irá procurar por uma tabela no banco de dados chamado *modelos*, por isso recomenda-se plural nas migrations e singular com a primeira letra em maíuscula nos modelos, isso é o comportamento padrão, podendo ser configurado posteriormente, mas até para evitar dores de cabeça, recomenda-se seguir o padrão. Todos os modelos estaram na pasta [app/Models/](./basico/app/Models), você também pode usar a opção `-m` para que seja criado junto uma Migration com base nesse Modelo, ficando `php artisan make:model [Nome] -m`.
### Migrations
`php artisan migrate` **=>** Executa as migrations que não foram executadas. As migrations ficam aqui: [database/migrations](./basico/database/migrations)

`php artisan make:migration [nomeDaTabela] --create=exemplo` **=>** Cria uma nova migration já preparado para a criação e exclusão de tabelas dentro do método *UP* e *DOWN* respectivamente. 
`[nomeDaTabela]` deve ser substituido pelo nome que a tabela deve ter no banco de dados. Lembre-se sempre de usar nomes no plural, pois isso facilita a configuração de modelos no Laravel.

#### Migrate:status
`php artisan migrate:status` **=>** Exibe quais migrate foram executados e quais não foram, exibirá um output como esse:

    | Ran? | Migration                                      | Batch |
    +------+------------------------------------------------+-------+
    | Yes  | 2014_10_12_000000_create_users_table           | 1     |
    | Yes  | 2014_10_12_100000_create_password_resets_table | 1     |
    | Yes  | 2019_08_19_000000_create_failed_jobs_table     | 1     |
    | Yes  | 2020_12_04_152328_exemplo1                     | 1     |
    | Yes  | 2020_12_04_210240_exemplo2                     | 1     |
    | Yes  | 2020_12_05_155827_modelos                      | 1     |
    +------+------------------------------------------------+-------+

A primeira coluna informa se foi executado, a segunda o nome da migration em questão e a segunda, em qual lota que foi aplicado, ou seja se ela foi executado na primeira execução do comando para a criação de migration, ou na segunda execução, ou na *N* execução. Todos que foram executados no ato de criação das tabelas no banco de o valor de *Batch* como 1, valores maiores de *batch* que 1 são atualização de estrutura e foram executado posteriormente a criação.    

`php artisan make:migration [nomeDaTabela]` **=>** cria uma migration com o método *UP* e *DOWN* limpo. `[nomeDaTabela]` deve ser substituido pelo nome que a tabela deve ter no banco de dados.

`php artisan migrate:rollback` **=>** retorna a migration ao último estado consistente. No caso esse comando executa o ultimo método *DOWN* da migration mais recente.


`php artisan migrate:refresh` **=>** Executa o método *down* da migration mais recente, desfazendo assim todas as operações e depois executa os métodos *up* das migrations da mais antiga até a mais recente, ou seja esse comando remodela as migrations.

`php artisan migrate:fresh` **=>** Essa migration ela dropa todas as tabelas e depois executa os métodos *UP* de todas as migrations.

`php artisan migrate:reset` **=>** O reset executa o método *DOWN* da migrate mais recente a mais antiga, resetando todas as configurações. 

## Tinker
No laravel tem um utilitário que auxilia no crud de uma aplicação, como ele você pode fazer operações de crud no terminal por meio de um **CLI**, comando `php artisan tinker`

### use
Inicialmente você deve informar o Modelo que você quer usar, os modelos ficam localizados na pasta [app/Models/](./basico/app/Models), você pode fazer esse acesso com o comando use, uma vez inicializado o tinker `use \App\Models\[Modelo]`, aonde está o `[Modelo]`, você deve informar o nome do arquivo de modelo.



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

### Erros envolvendo Migration

#### SQLSTATE[HY000] [1049] Unknown database
Se houver esse erro verifique se o banco de dados existe no SGBD.

#### SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: YES)
Problemas envolvendo as credenciais, pode ser senha erra, usuário errado, assim como IP ou porta errada.