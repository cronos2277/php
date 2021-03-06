# Middleware com Gerenciamento de Login

1. [Registrando Middlewares](#registrando-middlewares)
2. [Entendendo o funcionamento de Middlewares](#entendendo-o-funcionamento-de-middlewares)
3. [Login no Laravel](#login-no-laravel)
4. [Login Multiusuário no Laravel](#login-multiusuário-no-laravel)

## Registrando Middlewares
[Documentação](https://laravel.com/docs/8.x/middleware#introduction)

### Estrutura
Um middleware faz uma interceptação de requisição HTTP, geralmente usado para critérios de segurança, como por exemplo verificar se um usuário está logado por exemplo e caso não esteja, interceptar a requisição de modo que uma página que exige autenticação não carregue, esse seria um exemplo clássico de um middleware. No laravel existe quatro formas de fazer uso desse recurso, para tal, teremos [um controlador](./app/Http/Controllers/ControladorController.php) e quatro middleware,cada um deles interceptando de uma forma diferente.

### Criando um Middleware pelo Artisan
    php artisan make:middleware [nome]

Válido sempre ressaltar que a parte `[nome]` deve ser substituido pelo nome da classe correspondente. No exemplo abaixo o `middleware` se chama *Primeiro* e deve ter uma estrutura como essa:

    namespace App\Http\Middleware;
    use Closure;
    use Illuminate\Http\Request;

    class Primeiro
    {
        
        public function handle(Request $request, Closure $next)
        {
            return $next($request);
        }
    }

No caso toda a lógica referente a interceptação deve estar dentro da função `handle`, que vem da classe `\Illuminate\Http\Request`. A lógica aqui é semelhante ao `express` do javascript ou a qualquer outra coisa estruturada dessa forma, no caso se essa função `$next($request);` não for chamado passando o parametro `$request` o cliente não terá acesso ao conteúdo, mas continuando... No primeiro exemplo temos um middleware, Arquivo [Primeiro.php](./app/Http/Middleware/Primeiro.php): 

### Primeira forma: A forma mais simples e tradicional
    <?php
        namespace App\Http\Middleware;
        use Closure;
        use Illuminate\Http\Request;
        class Primeiro
        {
            public function handle(Request $request, Closure $next)
            {
                echo "<p style='color:blue;font-size:18px;'>Interceptado pelo primeiro middleware</p>";        
                return $next($request);
            }
        }

A primeira forma de registra-lo é encadeando o método `middleware` na rota, conforme visto no arquivo [web.php](./routes/web.php): `Route::get('/middleware',"\App\Http\Controllers\ControladorController@index")->middleware(\App\Http\Middleware\Primeiro::class);`, nesse caso ao encadear o método middleware a classe passada como parametro será usada para fazer a devida interceptação, lembre-se esse método aceita uma *Classe* como argumento, se for o caso o namespace deve ser informado. Além disso você não precisa importar nada no controlador por esse método, conforme visto no arquivo [ControladorController.php](./app/Http/Controllers/ControladorController.php).

    <?php
        namespace App\Http\Controllers;
        use Illuminate\Http\Request;
        class ControladorController extends Controller
        {
            public function index(){
                return "<br>Middleware index";
            }
        }

### Segunda Forma: Nomeando o middleware
Essa segunda requer que você registre o seu middleware no arquivo [Kernel.php](./app/Http/Kernel.php), nesse arquivo está todas os middleware que o Laravel usa, no entando, a rota em questão deve ser registrado dentro do array `$routeMiddleware`, também é válido lembrar que o carregamento das rotas é feito de cima para baixo:

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'segundo' => \App\Http\Middleware\Segundo::class
    ];

###### Segundo Middleware
[Segundo](./app/Http/Middleware/Segundo.php)

    <?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;

    class Segundo
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next)
        {
            echo "<p style='color:red;font-size:18px;'>Interceptado pelo segundo middleware</p>"; 
            return $next($request);
        }
    }

Repare que com essa rota adicionado `'segundo' => \App\Http\Middleware\Segundo::class` a nossa rota passa ter um nome, podendo ser reaproveitada por outros middlewares e claro, sem ter que expor o arquivo em questão. Agora basta adicionar o nome da rota em formato string a o método middleware, conforme o arquivo [web.php](./routes/web.php) ilustra:

    Route::get('/middleware',"\App\Http\Controllers\ControladorController@index")
        ->middleware(\App\Http\Middleware\Primeiro::class)
        ->middleware('segundo');

### Terceira forma: Instanciando no Controller.
Esse exemplo usaremos apenas para a terceira forma, repare que as outras duas primeiras sequer aparece no controlador como essa terceira forma:

###### Controller
[ControladorController.php](./app/Http/Controllers/ControladorController.php)

    <?php

        namespace App\Http\Controllers;
        use Illuminate\Http\Request;
        class ControladorController extends Controller
        {
            public function __construct()
            {
                $this->middleware(\App\Http\Middleware\Terceiro::class);        
            }
            public function index(){
                return "<br>Middleware index";
            }
        }

###### Middleware
[Terceiro](./app/Http/Middleware/Terceiro.php)

    <?php
        namespace App\Http\Middleware;

        use Closure;
        use Illuminate\Http\Request;

        class Terceiro
        {
            /**
             * Handle an incoming request.
             *
             * @param  \Illuminate\Http\Request  $request
             * @param  \Closure  $next
             * @return mixed
             */
            public function handle(Request $request, Closure $next)
            {
                echo "<p style='color:green;font-size:18px;'>Interceptado pelo terceiro middleware</p>"; 
                return $next($request);
            }
        }

Nessa terceira forma você chama o middleware através do construtor, você pode chamar direto a classe `$this->middleware(\App\Http\Middleware\Terceiro::class);` ou registrar-la no arquivo [Kernel.php](./app/Http/Kernel.php) e então chamar-la pelo nome dela, no caso `$this->middleware("[nome]");`, devendo `[nome]` ser o equivalente ao *nome* registrado no [Kernel.php](./app/Http/Kernel.php).

### Quarta forma: Forma Global
[Quarto.php](./app/Http/Middleware/Quarto.php)

    <?php

    namespace App\Http\Middleware;    
    use Closure;
    use Illuminate\Http\Request;

    class Quarto
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next)
        {
            echo "<p style='color:purple;font-size:18px;'>Interceptado pelo quarto middleware</p>"; 
            return $next($request);
        }
    }

[Kernel.php](./app/Http/Kernel.php)

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            //Quarto Middleware adicionado
            \App\Http\Middleware\Quarto::class
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

Dessa forma tudo que você deve fazer é ir ao arquivo [Kernel.php](./app/Http/Kernel.php) e adicionar o middleware no array `$middlewareGroups` e mais nada, não precisa registrar em nenhum método middleware, porém nesse método o seu middleware será carregado junto com o Laravel e de maneira global, apenas faça isso se quiser que todas as rotas do Laravel possam ser interceptadas pelo middleware.

**Se tudo funcionar corretamente:**

![Rotas Funcionando](./.imgs/middles_rotas_funcionando.png)

## Entendendo o funcionamento de Middlewares

###### First.php
[First.php](./app/Http/Middleware/First.php)

    <?php

        namespace App\Http\Middleware;
        use Closure;
        use Illuminate\Http\Request;

        class First
        {          
            public function handle(Request $request, Closure $next, $param1)
            {
                echo "<p style='color:blue;font-size:18px'>Executando  middleware PRÉ CONTROLLER FIRST com parametro $param1</p>";
                $req = $next($request);
                echo "<p style='color:blue;font-size:18px'>Executando middleware FIRST PÓS CONTROLLER com parametro $param1</p>";
                return $req;
            }
        }

**Repare que a classe `first` recebe um parametro, conforme visto aqui `$param1`.**

###### Second.php
[Second](./app/Http/Middleware/Second.php)

    <?php

        namespace App\Http\Middleware;

        use Closure;
        use Illuminate\Http\Request;

        class Second
        {            
            public function handle(Request $request, Closure $next, $param1, $param2)
            {
                echo "<p style='color:red;font-size:18px'>Executando middleware PRÉ CONTROLLER SECOND com parametros: [$param1,$param2]</p>";
                $req = $next($request);
                echo "<p style='color:red;font-size:18px'>Executando middleware SECOND PÓS CONTROLLER com parametros: [$param1,$param2]</p>";
                return $req;
            }
        }

**Repare que essa classe aceita 2 argumentos, conforme visto aqui `$param1, $param2`.**

###### Third.php
[Third.php](./app/Http/Middleware/Third.php)

    <?php

        namespace App\Http\Middleware;
        use Closure;
        use Illuminate\Http\Request;

        class Third
        {
            public function handle(Request $request, Closure $next)
            {
                $numero = random_int(0,10);
                if($numero >= 5){
                    echo "<p style='color:green;font-size:18px'>Executando middleware THIRD PRÉ CONTROLLER sem parametros e podendo interceptar.</p>";
                    $req = $next($request);
                }else{
                    echo "Valor de número = $numero, ou seja o MIDDLEWARE vai bloquear";
                    return response("BLOQUEADO!!!!",403);
                }
                
                echo "<p style='color:green;font-size:18px'>Executando middleware THIRD PÓS CONTROLLER sem parametros e podendo interceptar.</p>";
                return $req;
            }
        }

### Entendendo os Middlewares

###### Registrando os Middlewares
    Route::get('/controle',"\App\Http\Controllers\IndexCtrl@index")
    ->middleware(
        "\App\Http\Middleware\First:1",
        "\App\Http\Middleware\Second:2,3",
        "\App\Http\Middleware\Third"
    );

#### Sobre os parametros passados ao Middleware.
Aqui está sendo registrado os middlewares, essa é uma forma possível quando você quer passar parametros ao middleware, você poderia nomear as rotas e colocar os dois pontos após o nome registrado no arquivo **Kernel.php**. Porém definido isso, conforme visto aqui `"\App\Http\Middleware\First:1"`, tudo que houver após os dois pontos, será passado como argumento. A exemplo dessa classe [FIRST](#firstphp), nesse caso tem como parametro `1` e será passado como argumento para `$param1`, se você quiser passar mais de um argumento, você pode usar a `,` como separador, conforme visto aqui `"\App\Http\Middleware\Second:2,3"`, no [SECOND](#secondphp), repare que em ambos, os parametros adicionais são informados na assinatura do método `handler`.

#### Brecando o carregamento do indice:

    public function handle(Request $request, Closure $next)
        {
            $numero = random_int(0,10);
            if($numero >= 5){
                echo "<p style='color:green;font-size:18px'>Executando middleware THIRD PRÉ CONTROLLER sem parametros e podendo interceptar.</p>";
                $req = $next($request);
            }else{
                echo "Valor de número = $numero, ou seja o MIDDLEWARE vai bloquear";
                return response("BLOQUEADO!!!!",403);
            }
            
            echo "<p style='color:green;font-size:18px'>Executando middleware THIRD PÓS CONTROLLER sem parametros e podendo interceptar.</p>";
            return $req;
        }

Nesse caso você se essa condição `if($numero >= 5)` for falsa, a execução será suspensa, devido ao visto aqui `return response("BLOQUEADO!!!!",403);`, no caso esse `$numero` recebe um número aleatório ente *1* e *10*, conforme esta expressão: `$numero = random_int(0,10);`. Abaixo um exemplo quando o middleware suspende a execução:

![Interceptando o Middleware](./.imgs/interceptando_middleware.png)

### ordem de execução dos Middlewares
[IndexCtrl](./app/Http/Controllers/IndexCtrl.php)

    <?php
        namespace App\Http\Controllers;
        use Illuminate\Http\Request;
        class IndexCtrl extends Controller
        {
            public function index(){
                return "<h1>Carregando indice</h1>";
            }
        }

**Existe uma ordem para a execução de middlewares, inicialmente é executado do primeiro middleware até o ultimo sequencialmente, porém quando todos os middlewares são executados, a exibição passa a ocorre de maneira inversa, ou seja o ultimo middleware é executado antes do primeiro, em outras palavras: o primeiro middleware é executado, depois o segundo e por fim o terceiro, no caso todo o trecho antes da chamada do next, uma vez que todo o trecho da chamada do next é executado, começar a ser executado o trecho após a chamada do next, começando do terceiro, indo ao segundo e após isso voltando ao primeiro, lembrando que nessa rota de volta, a requisição já foi carregada e com isso é possível fazer pós processamento, e ai depois de todo esse processo de ida e volta gerado pelos middlewares, ai sim a requisição é carregada. Segue um print abaixo para clarificar isso:**

![Middles Rotas Exec](.imgs/middles_rotas_exec.png)

## Login no Laravel
Para habilitar o login no Laravel 5 basta dar o comando `php artisan make:auth`, porém na atual versão (8.0), a maneira é um pouco diferente...

### composer require laravel/ui "^[VERSAO]"
    composer require laravel/ui "^1.0" --dev

**OU**

    composer require laravel/ui "^2.0"

Repare que a flag `--dev` indica desenvolvimento e não deve ser usado em ambiente de produção, você precisa instalar o `laravel/ui` para ter acesso a um wizard nas novas versões do *Laravel*.

#### Possível erro

     Problem 1
    - laravel/ui[v1.0.0, ..., 1.x-dev] require illuminate/console ~5.8|^6.0 -> found illuminate/console[v5.8.0, ..., 5.8.x-dev, v6.0.0, ..., 6.x-dev] but these were not loaded, likely because it conflicts with another require.
    - Root composer.json requires laravel/ui ^1.0 -> satisfiable by laravel/ui[v1.0.0, ..., 1.x-dev].

Se um erro semelhante ao informado acima, verifique as versões dos pacotes instalados no projeto, se você está usando a versão mais nova do `Laravel` convém usar a versão mais nova do `laravel/ui`. Além disso o `^` indica que será instalado o recurso entre a versão `2.0.0` e `2.9.9`.

### Instalando o bootstrap
    php artisan ui bootstrap

Dessa forma você instala o bootstrap e é solicitado a rodar o *npm*: `Please run "npm install && npm run dev" to compile your fresh scaffolding.`    
### ui com VUE
Aqui usaremos o utilitário executando: `php artisan ui vue --auth`, uma vez que o mesmo seja instalado seguindo os [passos acima](#login-no-laravel). Após isso recomenda-se rodar o `npm i` e o `npm i -D`, ou seja atualizar os pacotes npm de produção e desenvolvimento. Nesse exemplo está sendo instalado o vue junto no front-end e é solicitado a rodar o *npm*: `Please run "npm install && npm run dev" to compile your fresh scaffolding.`.

### ui auth

    php artisan ui:auth

Esse Script deve ser executado antes ou depois de instalar o `vue` ou o `bootstrap` caso você instale isso, esse script irá criar alguns arquivos:

[web.php](routes/web.php)

    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');

Repare que o Laravel cria a rota **/home** na aplicação, você pode alterar isso se quiser, mas por padrão é o **/home** e caso haja algum problema, você pode definir o namespace completo dessa rota, conforme ilustrado [aqui](#erros-ao-executar-o-php-artisan-routelist)

**Além disso irá criar os seguintes arquivos PHP:** 

[ConfirmPasswordController.php](app/Http/Controllers/Auth/ConfirmPasswordController.php) -> Confirmação de Senhas.

[ForgotPasswordController.php](app/Http/Controllers/Auth/ForgotPasswordController.php) -> Página de registro para redefinição de uma nova senha.

[LoginController.php](app/Http/Controllers/Auth/LoginController.php) -> Página para Login.

[RegisterController.php](app/Http/Controllers/Auth/RegisterController.php) -> Página para registro de uma nova conta.

[ResetPasswordController.php](app/Http/Controllers/Auth/ResetPasswordController.php) -> Página que irá proceder com o reset da senha.

[VerificationController.php](app/Http/Controllers/Auth/VerificationController.php) -> Página que lida com verificação de e-mail.

#### Home Controller
[Arquivo](app/Http/Controllers/HomeController.php), Esse será o controller que o *Laravel* criará para acessar o login de usuário na aplicação.

    <?php

        namespace App\Http\Controllers;

        use Illuminate\Http\Request;

        class HomeController extends Controller
        {
            /**
            * Create a new controller instance.
            *
            * @return void
            */
            public function __construct()
            {
                $this->middleware('auth');
            }

            /**
            * Show the application dashboard.
            *
            * @return \Illuminate\Contracts\Support\Renderable
            */
            public function index()
            {
                return view('home');
            }
        }

### Erros ao executar o php artisan route:list
Se houver algum erro ao executar esse comando `php artisan route:list`, vai até o arquivo de rotas [web.php](routes/web.php), nesse arquivo você coloca o caminho absoluto a rota, no caso na rota de autenticação você deve encontrar algo como:
###### Path para homeController errado:
    Route::get('/home', 'HomeController@index')->name('home');

**Sendo que o mesmo deve ficar:**

###### Path para homeController Certo:
    Route::get('/home', '\App\Http\Controllers\HomeController@index')->name('home');

### Tabela de rotas
Uma vez que o problema de rotas esteja resolvido o output deve ser algo como:

    +--------+----------+------------------------+------------------+------------------------------------------------------------------------+---------------------------------+
    | Domain | Method   | URI                    | Name             | Action                                                                 | Middleware                      |
    +--------+----------+------------------------+------------------+------------------------------------------------------------------------+---------------------------------+
    |        | GET|HEAD | /                      |                  | Closure                                                                | web                             |
    |        | GET|HEAD | api/user               |                  | Closure                                                                | api                             |
    |        |          |                        |                  |                                                                        | auth:api                        |
    |        | GET|HEAD | controle               |                  | App\Http\Controllers\IndexCtrl@index                                   | web                             |
    |        |          |                        |                  |                                                                        | \App\Http\Middleware\First:1    |
    |        |          |                        |                  |                                                                        | \App\Http\Middleware\Second:2,3 |
    |        |          |                        |                  |                                                                        | \App\Http\Middleware\Third      |
    |        | GET|HEAD | home                   | home             | App\Http\Controllers\HomeController@index                              | web                             |
    |        |          |                        |                  |                                                                        | auth                            |
    |        | GET|HEAD | login                  | login            | App\Http\Controllers\Auth\LoginController@showLoginForm                | web                             |
    |        |          |                        |                  |                                                                        | guest                           |
    |        | POST     | login                  |                  | App\Http\Controllers\Auth\LoginController@login                        | web                             |
    |        |          |                        |                  |                                                                        | guest                           |
    |        | POST     | logout                 | logout           | App\Http\Controllers\Auth\LoginController@logout                       | web                             |
    |        | GET|HEAD | middleware             |                  | App\Http\Controllers\ControladorController@index                       | web                             |
    |        |          |                        |                  |                                                                        | App\Http\Middleware\Primeiro    |
    |        |          |                        |                  |                                                                        | segundo                         |
    |        |          |                        |                  |                                                                        | App\Http\Middleware\Terceiro    |
    |        | GET|HEAD | password/confirm       | password.confirm | App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm    | web                             |
    |        |          |                        |                  |                                                                        | auth                            |
    |        | POST     | password/confirm       |                  | App\Http\Controllers\Auth\ConfirmPasswordController@confirm            | web                             |
    |        |          |                        |                  |                                                                        | auth                            |
    |        | POST     | password/email         | password.email   | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web                             |
    |        | GET|HEAD | password/reset         | password.request | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web                             |
    |        | POST     | password/reset         | password.update  | App\Http\Controllers\Auth\ResetPasswordController@reset                | web                             |
    |        | GET|HEAD | password/reset/{token} | password.reset   | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web                             |
    |        | GET|HEAD | register               | register         | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web                             |
    |        |          |                        |                  |                                                                        | guest                           |
    |        | POST     | register               |                  | App\Http\Controllers\Auth\RegisterController@register                  | web                             |
    |        |          |                        |                  |                                                                        | guest                           |
    +--------+----------+------------------------+------------------+------------------------------------------------------------------------+---------------------------------+

Essas rotas acima, são criados com base nos script [php artisan ui:auth](#ui-auth)

#### Class App\User not found ao Registrar uma nova conta
No caso por bug o laravel pode não colocar o path correto para o usuário, no arquivo [RegisterController.php](app/Http/Controllers/Auth/RegisterController.php) em [app\Http\Controllers\Auth\](./app/Http/Controllers/Auth), no começo, na parte de importação:

    namespace App\Http\Controllers\Auth;
    use App\Http\Controllers\Controller;
    use App\Providers\RouteServiceProvider;
    use App\User;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

Mude `use App\User;` para `use App\Models\User;`

### Arquivo Blade gerado
[Arquivo não gerado](./resources/views/welcome.blade.php)

[Arquivo gerado, app](./resources/views/layouts/app.blade.php)

[Arquivo gerado, home](./resources/views/home.blade.php)

Também tem os arquivos [gerados na pasta auth](./resources/views/auth).

### @auth e @guest
#### @auth
    @auth                        
        <div class="card-header">Usuário {{Auth::user()->id}}</div>
        <div class="card-body">
            <h5 class="card-title">
                Nome: {{Auth::user()->name}}, 
                <br> 
                email: {{Auth::user()->email}}</h5>
            </div>                                                        
            <p class="card-text">
                Conteúdo de: <strong>Auth::user()</strong>
                <br />
                {{dd(Auth::user())}}
            </p>                            
        </div>
    @endauth

**O parte do html dentro de `@auth` é exibido apenas aos usuários que estejam logados, caso o usuário não esteja logado, esse trecho será omitido.** Sintaxe inicia-se com `@auth` e termina com `@endauth`.

##### Auth::user
Esse método retorna um objeto `App\Models\User` com os dados do usuário logado, ou nulo caso o usuário não esteja logado.

![Auth->user](./.imgs/Objeto_retornado_Auth-user.png)
#### @guest
    @guest
    <div class="card-header">Visitante</div>
    <div class="card-body">
        <p class="card-text">
            Conteúdo de: <strong>Auth::user()</strong>
            <br />
            {{dd(Auth::user())}}
        </p>
    </div>
    @endguest       

Esse método funciona de maneira oposta a `@auth`, ou seja o `@guest` apenas carrega o seu trecho de código **APENAS** se o usuário **NÃO** estiver logado, além disso o método `Auth::user()` retorna nulo.

### Obrigando o usuário estar logado para acessar certas rotas
Para que você obrigue o login no acesso de certas rotas, tudo que você precisa fazer é colocar o `"auth"` como `middleware` da rota. Por exemplo nessa rota abaixo:

    Route::get('/middleware',"\App\Http\Controllers\ControladorController@index")
        ->middleware(\App\Http\Middleware\Primeiro::class)
        ->middleware('segundo');

basta adicionar o middleware, ficando:

    Route::get('/middleware',"\App\Http\Controllers\ControladorController@index")
    ->middleware("auth")
    ->middleware(\App\Http\Middleware\Primeiro::class)
    ->middleware('segundo');

## Login Multiusuário no Laravel

### Classe User Dentro de models
[Classe User que extende Authenticatable](./app/Models/User.php)
###### Classe User que extende Authenticatable
    <?php

    namespace App\Models;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        use HasFactory, Notifiable;        
        protected $fillable = [
            'name',
            'email',
            'password',
        ];

        protected $hidden = [
            'password',
            'remember_token',
        ];

        protected $casts = [
            'email_verified_at' => 'datetime',
        ];
    }

#### Explicação sobre a Classe dentro User.php
***`php artisan make:auth` você precisa desse comando antes de começar, ou `composer require laravel/ui "^1.0"` ou `composer require laravel/ui "^2.0"`, mais informação [aqui](#login-no-laravel).***

Como você pode ver nesse trecho `class User extends Authenticatable`, essa interface **Authenticatable**, como você pode ver aqui `use Illuminate\Foundation\Auth\User as Authenticatable;`, extende da classe **User** e é referenciada como `Authenticatable`. Ou seja essa classe seria parecida com a classe **Model**, mas com alguns incrementos a mais. Essa é a classe que o Laravel usa para gerenciar os usuários logados, caso você queira criar diferente níveis de permissões, inicialmente você deve duplicar essa classe, se por exemplo você quiser criar diferente níveis de permissão, por exemplo, uma permissão para um usuário comum e outra para administrador, se faz necessário duplicar essa classe e criar uma classe com o seu respectivo migration. ***Nesse exemplo será criado a Classe [Admin.php](./app/Models/Admin.php) que será um clone dessa [User.php](./app/Models/User.php).***

    php artisan make:migration create_admins_table --create=admins

***A migration em questão é criada com o comando acima, com o procedimento acima concluído, logo o foco passa a ser outro arquivo: [auth.php](./config/auth.php).*** 

    <?php

        return [
            'defaults' => [
                'guard' => 'web',
                'passwords' => 'users',
            ],

            'guards' => [
                'web' => [
                    'driver' => 'session',
                    'provider' => 'users',
                ]
            ],

            'api' => [
                    'driver' => 'token',
                    'provider' => 'users',
                    'hash' => false,
                ],
            ],   

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

            'passwords' => [
                'users' => [
                    'provider' => 'users',
                    'table' => 'password_resets',
                    'expire' => 60,
                    'throttle' => 60,
                ],
            ],  

            'password_timeout' => 10800,

        ];

##### Guardas

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
            ]
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],   

Essa parte diz respeito a forma de autenticação, no caso temos o web, que é quando o cliente acessa pelo navegador e api, que seria uma forma de acesso por `AJAX` ou `CURL`, por exemplo. O `driver` é o modo aonde essa autenticação será mantida, se será na sessão, ou em token, nesse caso o acesso via navegador é sessão e a api é via token. O `provider` é aonde estará armazenado os usuários, nesse exemplo ambos estarão dentro do provedor `users`, que por padrão pode ser um model, ou uma tabela de banco de dados.
##### Provedores

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

Aqui temos os provedores, ou seja quem irá nos fornecer os dados, em drivers temos a princípio duas opções sendo `Eloquent` ou o `Query Builder`, esse segundo caso seja informado `database` como driver. No caso aqui, especificamos a forma como o *Laravel* fará acesso aos dados, caso seja `eloquent` devemos informar qual é o *Model* correspondente, caso seja database, devemos informar o nome da tabela do banco de dados, ao qual o laravel se conecta através do arquivo [.env](.env).

##### Passwords

     'passwords' => [
            'users' => [
                'provider' => 'users',
                'table' => 'password_resets',
                'expire' => 60,
                'throttle' => 60,
            ],
        ],  

Aqui é guardado informações, caso seja requerido um *reset* na senha, ou seja essa tabela gerencia os tokens para a criação de novas senhas caso o usuário solicite. Nessa parte `'users' =>` você cria um perfil para passwords, aqui `'provider' => 'users',` qual será o provedor a ser usado, para mais detalhes [aqui](#provedores). Aqui `'table' => 'password_resets',` a tabela aonde ficará armazenado os tokens, essa parte `'expire' => 60,` refere-se a quantidade de minutos que o link gerado será válido, passado esse tempo, o link criado para a redefinição de senha não será mais válido. Por fim `'throttle' => 60,`, permite que um usuário solicite 1 token por 60 segundos, ou seja a frequência em segundos que o token é válido e atualizado.

`'password_timeout' => 10800,` => Quantidade de segundos que o password é válido, após esse tempo o usuário deve, fazer o login novamente. Nesse caso temos 3 horas, após isso o usuário deve fazer o login novamente.

##### Comportamento padrão

    'defaults' => [
            'guard' => 'web',
            'passwords' => 'users',
    ],

Aqui é a parte que informa, qual será o comportamento padrão do formulário, sendo o `'guard' => 'web',` o guard we quando não especificado nenhum conforme visto [aqui](#guardas) e usando as configurações para senha, conforme visto [aqui](#passwords)

### Adicionando um novo adminstrador
###### arquivo auth.php

    <?php

    return [   
        'defaults' => [
            'guard' => 'web',
            'passwords' => 'users',
        ],   

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

            'admin' => [ //Isso aqui deverá ser informado posteriormente em App\Models\Admin::class
                'driver' => 'session',
                'provider' => 'admins',
            ],

            'admin-api' => [ //Isso aqui deverá ser informado posteriormente em App\Models\Admin::class
                'driver' => 'token',
                'provider' => 'admins',
                'hash' => false,
            ],
        ],    

        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => App\Models\User::class,
            ],

            'admins' => [ //Aqui especificamos um provedor para o tipo de usuario Administrador
                'driver' => 'eloquent',
                'model' => App\Models\Admin::class, //O modelo mudou.
            ],

            // 'users' => [
            //     'driver' => 'database',
            //     'table' => 'users',
            // ],
        ],    

        'passwords' => [
            'users' => [
                'provider' => 'users',
                'table' => 'password_resets',
                'expire' => 60,
                'throttle' => 60,
            ],
            'admins' => [ //O administrador usuara a mesma tabela de senha 'password_resets' do usuario, mas o provider é diferente
                'provider' => 'admins', //Provider do administrador
                'table' => 'password_resets',
                'expire' => 60,
                'throttle' => 60,
            ],
        ],   

        'password_timeout' => 10800,

    ];

###### Admin.php

    <?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class Admin extends Authenticatable
    {
        use HasFactory, Notifiable;

        protected $guard = "admin"; //Voce precisa informar o guard aqui.
        
        protected $fillable = [ //Os campos que esse modelo deve conter
            'name',
            'email',
            'password',
        ];

        
        protected $hidden = [
            'password',
            'remember_token',
        ];

        
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];
    }

Dessa classe acima, destaque para essa linha `protected $guard = "admin"; //Voce precisa informar o guard aqui.`, pois é nessa instrução que o arquivo de guard será lido esse:

    'guards' => [
           ...

            'admin' => [ //Isso aqui deverá ser informado posteriormente em App\Models\Admin::class
                'driver' => 'session',
                'provider' => 'admins',
            ],

            ...
        ],    

Ao invés desse: 

     'defaults' => [
            'guard' => 'web',
            'passwords' => 'users',
    ],

#### Campos que todo administrador deve ter

    protected $fillable = [ //Os campos que esse modelo deve conter
            'name',
            'email',
            'password',
        ];

No caso o administrador deve ser como campo, conforme informado acima `name`, `email`, `password`, que são os preenchíveis, além disso temos, dois campos ocultos:

    protected $hidden = [
        'password',
        'remember_token',
    ];

E mais um campo que deve ser convertido corretamente para `datetime` antes de ser salvo no banco de dados: 

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
#### Prosseguindo na criação dos administradores
Uma vez feito todo o procedimento acima, criaremos um controlador, através de: `php artisan make:controller AdminController`. Com isso criamos o arquivo [AdminController](./app/Http/Controllers/AdminController.php), sendo adicionado a esse arquivo o seguinte código:

    <?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    class AdminController extends Controller
    {
        public function __construct()
        {
            $this->middleware('auth:admin');    
        }

        public function index()
        {
            return view('admin');
        }
    }

Aqui indicamos o middleware `$this->middleware('auth:admin');`, o *auth* seria para o guard padrão, no caso esse `admin`, seria para esse guard:

    'guards' => [
           ...

            'admin' => [ //Isso aqui deverá ser informado posteriormente em App\Models\Admin::class
                'driver' => 'session',
                'provider' => 'admins',
            ],

            ...
        ],    

Após isso é definido a rota, no arquivo de rotas [web.php](./routes/web.php): `Route::get('/admin','\App\Http\Controllers\AdminController@index')->name('homeadmin');`, passando o nome dessa rota a ser **homeadmin** e carregando o arquivo [admin.blade.php](./resources/views/admin.blade.php) quando o usuário estiver logado.

### Ajustando a página para Login
Você pode criar um controlador que irá alterar o comportamento de login do laravel, para isso, crie um arquivo controlador dentro da pasta [Auth](./app/Http/Controllers/Auth). Por padrão o `make:controller` cria os arquivos na pasta [Controllers](./app/Http/Controllers), para isso `php artisan make:controller Auth/AdminLoginController`. *Uma vez feito isso:*

    <?php

    namespace App\Http\Controllers\Auth;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class AdminLoginController extends Controller
    {
        public function __construct()
        {
            $this->middleware('guest:admin');
        }
        
        public function login(Request $request){
            return true;
        }

        public function index(){
            return view('auth.admin-login');
        }

    }

**Sobre o código adicionado acima, a parte mais relevante é essa:**

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

ele funciona de maneira oposta ao *guard do admin*, [conforme visto aqui](#adminphp). No caso se o usuário não estiver logado com o Guard admin o acesso não segue.

#### Criando rotas e o arquivo Blade
Uma vez concluído o processo acima, podemos continuar informando a rota, ficando no arquivo [web.php](./routes/web.php):

    Route::get('/admin','\App\Http\Controllers\AdminController@index')->name('admin.dashboard');
    Route::get('/admin/login','\App\Http\Controllers\AdminLoginController@login')->name('admin.login');
    Route::post('/admin/login','\App\Http\Controllers\AdminController@login')->name('admin.login.submit');

**Claro que você precisa ter as rotas de autenticação também `Auth::routes();`. Algo que você consegue fazendo [isso aqui](#login-no-laravel).**

### Aplicando regras de login
[AdminLoginController](.\app\Http\Controllers\Auth\AdminLoginController.php)

    class AdminLoginController extends Controller
    {
        public function __construct() {
            $this->middleware('guest:admin');            
        }

        public function index() {
            return view('auth.admin-login');
        }

        public function login(Request $request) {            
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);           
            
            $credentials = [ 'email'    => $request->email,'password' => $request->password ];                       
            $authOk = Auth::guard('admin')->attempt($credentials, $request->remember);


            // se ok, então direcionar para a localização interna
            if ($authOk) {                
                return redirect()->intended(route('admin.dashboard'));
            }
            
            // se não, redirecionar novamente para o login, passando novamente os parametros do request
            return redirect()->back()->withInput($request->only('email','remember'));
        }
    }

###### somente quem não estiver logado como admin terá acesso ao login
    public function __construct() 
    {
        $this->middleware('guest:admin');            
    }

###### validar o dado que vem do formulario 
    $this->validate($request,
    [
        'email' => 'required|email',
        'password' => 'required'
    ]);

###### Utilizando o guard do admin.
`Auth::attempt($credentials, $remember);`  **=>** *se eu utilizar assim, utilizarei o 'default' e nao o novo, admin.*

    $authOk = Auth::guard('admin')->attempt($credentials, $request->remember);

###### se ok, então direcionar para a localização interna
**Quando um usuário tenta acessar uma página que necessita de login e o Laravel redireciona direto pro login, essa página é mantida pelo framework e pode ser chamada através do método `redirect()->intended()`. Se nao houver nenhuma página requisitada anterior ao login, o Laravel redireciona para a rota passada por parâmetro:**

    if ($authOk) {                
        return redirect()->intended(route('admin.dashboard'));
    }

Válido ressaltar que o método *intent*, analisa as rotas filhos, como por exemplo: `/admin/qualquercoisa/qualquercoisa`.
###### se não, redirecionar novamente para o login, passando novamente os parametros do request
    return redirect()->back()->withInput($request->only('email','remember'));

No caso esse método `->back()` faz o redirecionamento para aonde o usuário estava, ao passo que este `->withInput($request->only('email','remember'))`, transmite os dados informados pelos usuários, para que ele não precise digitar novamente, no caso esse `'email'` faz referenciar ao objeto `Request` do input `email`, no caso: `$request->input('email')` e `$request->input('remember')`, respectivamente.

### especificando a pagina para logins
Para que o usuário possa logar como um usuário comum ou administrador, dependendo da url informada, se faz necessário alterar esse arquivo [app\Exceptions\Handler.php](.\app\Exceptions\Handler.php), no caso, adicionando ao arquivo esse método abaixo, que originalmente não existia no arquivo:

    protected function unauthenticated($request, AuthenticationException $exception)
    {        
        if($request->expectsJson()){
            return response()->json(
                [
                    'message' => $exception->getMessage()
                ], 401
            );
        }

        $guard = \Illuminate\Support\Arr::get($exception->guards(),0);
        switch($guard){
            case "admin": $login = "admin.login";
                break;
            case "web": $login = "login";
                break;
            default: $login = "login";
        }

        return redirect()->guest(route($login));
    }

Nesse código acima será analisado duas coisas, caso o usuário não esteja logado e tente acessar o dashboard do usuário ou administrador, no caso isso dará um erro do tipo `AuthenticationException`, que por sua vez será intercptado aqui, podendo acontecer uma de três coisas:

     if($request->expectsJson()){
            return response()->json(
                [
                    'message' => $exception->getMessage()
                ], 401
            );
        }

#### Requisição JSON
Se ocorrer uma requisição que pede o retorno de um *json*, esse desvio condicional é executado e com isso o erro *401* é retornado ao cliente.

     if($request->expectsJson()){
            return response()->json(
                [
                    'message' => $exception->getMessage()
                ], 401
            );
        }

#### Outras requisições

    $guard = \Illuminate\Support\Arr::get($exception->guards(),0);
        switch($guard){
            case "admin": $login = "admin.login";
                break;
            case "web": $login = "login";
                break;
            default: $login = "login";
        }

        return redirect()->guest(route($login));

Caso a requisição seja por navegador, a lógica será essa, se for administrador essa váriavel `$login` recebe a rota de login do administrador, do contrário segue para a rota de login para usuários comuns se autenticarem e prosseguirem com o login.

#### Verificando quem está logado
[Arquivo RedirectIfAuthenticated.php](.\app\Http\Middleware\RedirectIfAuthenticated.php)


    class RedirectIfAuthenticated
    {
        /**
        * Handle an incoming request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \Closure  $next
        * @param  string|null  ...$guards
        * @return mixed
        */
        public function handle(Request $request, Closure $next, ...$guards)
        {
            $guards = empty($guards) ? [null] : $guards;

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    return redirect(RouteServiceProvider::HOME);
                }
            }

            return $next($request);
        }
    }

Nesse código acima, idependente de quem está logado, o dashboard a ser direcionado será o do usuário comum, para evitar esse bug, precisa também verificar aqui se o mesmo não é administrador e caso seja direcionar o administrador ao dashboard do administrador e o do usuário comum ao seu respectivo, e não ambos ao mesmo como é feito aqui.

##### Resolvendo a questão dos dashboards.

    ...
    foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if($guard == "admin"){
                    return redirect()->route('admin.dashboard');
                }
                return redirect(RouteServiceProvider::HOME);
            }
        }
    ...

No caso basta colocar um desvio condicional para verificar se o usuário é um administrador no arquivo [app\Http\Middleware\RedirectIfAuthenticated.php](.\app\Http\Middleware\RedirectIfAuthenticated.php).

    if($guard == "admin"){
        return redirect()->route('admin.dashboard');
    }