# Formulário no Laravel e Eloquent

##### Formulários
1. [Validando Formulários](#validando-formulários)
2. [Transformando dados em JSON](#transformando-dados-em-json)
3. [Retornando códigos HTTP](#retornando-códigos-http)
4. [Requisição AJAX no Laravel](#requisição-ajax)
5. [Seeders](#seeders)
6. [Erros Possíveis](#erros-possíveis)
7. [Eloquent - 1 para 1 ](#eloquent-um-para-um)
8. [Eloquent - 1 para N ](#eloquent-um-para-muitos)
9. [Eloquent - N para N](#eloquent---muitos-para-muitos)
## Validando formulários
[Documentação para validadores](https://laravel.com/docs/8.x/validation#available-validation-rules)

[arquivo controller](app/Http/Controllers/FormularioController.php)

    public function store(Request $request)
    {
        $request->validate(
            [
                'nome_form' => ['required','min:3','max:99'],
                'email_form' => 'required|email|unique:formularios,email',
                'idade_form' => 'required'                
            ]
        );
        
    }

[arquivo blade](resources/views/page/create.blade.php)

    <form class="row g-3 mt-3" action="/store" method="POST">
      @csrf
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text">Nome</span>
            <input type="text" class="form-control @if($errors->has('nome_form')) is-invalid @endif" placeholder="Nome" aria-label="Nome" name="nome_form">
            <div class="invalid-feedback">@if($errors->has('nome_form')) {{$errors->first('nome_form')}} @endif</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
              <span class="input-group-text">@</span>
              <input type="text" class="form-control @if($errors->has('email_form')) is-invalid @endif"" placeholder="E-mail" aria-label="E-mail" name="email_form">
              <div class="invalid-feedback">@if($errors->has('email_form')) {{$errors->first('email_form')}} @endif</div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="input-group">
            <span class="input-group-text">Idade</span>
            <input type="text" class="form-control @if($errors->has('idade_form')) is-invalid @endif"" placeholder="Idade" aria-label="Idade" name="idade_form">
            <div class="invalid-feedback">@if($errors->has('idade_form')) {{$errors->first('idade_form')}} @endif</div>
          </div>  
        </div>
        <div class="col-md-3 col-6">
          <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="text" class="form-control @if($errors->has('sal_form')) is-invalid @endif"" placeholder="salario" aria-label="salario" name="sal_form">
            <div class="invalid-feedback">@if($errors->has('sal_form')) {{$errors->first('sal_form')}} @endif</div>
          </div>
        </div>        
        <button type="reset" class="btn btn-warning col-md-2 col-5 mx-2">Limpar</button>
        <button type="submit" class="btn btn-success col-md-2 col-5 mx-2">Submeter</button>        
    </form>


Essa é a forma mais básica, caso os dados informados pelo cliente não bata com as regras acima o **Laravel** faz o redirecionamento e faz o envio com um array contendo as informações chamada de `$errors`, sem exibir uma página de erro técnica ao usuário, caso algum campo obrigatório esteja nulo, o nome do método se chama **validate**, além ao qual vem do objeto **$request**.

    'idade_form' => 'required'

Esse exemplo acima é o maís básico. A esquerda está o nome do campo no formulário, no caso o *input* referente a isso é `<input type="text" class="form-control @if($errors->has('idade_form')) is-invalid @endif"" placeholder="Idade" aria-label="Idade" name="idade_form">`, como você pode ver nesse *input* temos `name="idade_form"`, esse é o valor que deve ser informado como chave do array, a direita as validações, a direita `'required'` temos os validadores, no caso, esse indica que o campo é obrigatório.

    'nome_form' => ['required','min:3','max:99']

Você também pode passar mais de um validador em forma de array, no caso além de ser obrigatório esse campo exige que o input tenha um tamanho entre 3 caracteres até no máximo 99. Além disso os valores passados para cada validação fica a direita dos dois pontos, por exemplo `'min:3'` o *min* tem o valor *3*, assim como `'max:99'` o *max* tem como valor *99*.

    'email_form' => 'required|email|unique:formularios,email',

Uma outra forma de fazer isso é colocar isso tudo dentro de uma string única separado por pipes `|`, como nesse exemplo `'required|email|unique:formularios,email'`, a validação de `email` informa ao *Laravel* que o campo em questão é de e-mail e dessa forma o *Laravel* verifica se o e-mail é válido. Por fim temos o campo `unique`, que evita duplicidade do dado, a vírgula auxilia na passagem de mais de um parâmetro, caso esse parametro pode funcionar com um ou dois parametros, quando o name do formulário e o campo na tabela tem o mesmo nome, o segundo argumento pode ser omitido, quando o name de um input é diferente do nome do campo da tabela no banco de dados, logo o segundo parametro serve para esclarecer isso.

`unique:formularios` => Tanto o atributo `name` do formulário como o campo no banco de dados possuem o mesmo nome e a tabela a ser verifica se o dado informado pelo usuário já existe ou não, seria a tabela formulário, no caso esse campo é pegado com base no index do array `email_form`.

`unique:formularios,email'` => Aqui estamos deixando claro que o campo correspondente na tabela formularios do banco de dados não é `email_form` e sim `email`, ou seja que `email_form` corresponde a `email` na tabela formularios.

### Validação com mensagens customizáveis
[Documentação para exibir mensagens customizáveis](https://laravel.com/docs/8.x/validation#specifying-custom-messages-in-language-files)

    $request->validate(
        [ //Validacoes
            'nome_form' => ['required','min:3','max:99'],
            'email_form' => 'required|email|unique:formularios,email',
            'idade_form' => 'required|integer',
            'sal_form' => 'nullable|numeric'
        ],
        [ //Mensagens
            'required' => 'O campo :attribute é obrigatório.',
            'nome_form.min' => 'O nome precisa ter no mínimo 3 caracteres.',
            'nome_form.max' => 'Nome com mais de 99 caracteres.',
            'email' => 'Por favor, informe um e-mail válido!',
            'email_form.unique' => 'Esse e-mail já foi usado anteriormente.',            
            'numeric' => 'Esse :attribute recebe apenas valores numéricos.',
            'integer' => 'Esse :attribute recebe apenas valores inteiros.'
        ]
    );

`integer` => Verifica se o valor informado é um número inteiro.

`numeric` => Verifica se o valor informado é real, pondendo ser um número inteiro ou decimal.

`nullable` => Informa ao laravél que esse campo pode ser nulo e se não nulo, ele deve seguir as outras validações, ou nulo ou deve seguir todas as validações.

### Segundo array do método validate
O segundo método é caso você queira exibir mensagens customizável, por padrão as mensagens são em inglês e essa seria uma forma de você exibir uma mensagem em português por exemplo.
A regra pode ser definida para campo ou para um validador: `'required' => 'O campo :attribute é obrigatório.',`, no caso se houver algum campo com esse validador, essa será a mensagem a ser exibida exceto que tenha uma regra mais específica, como por exemplo `'email_form.required' => 'O campo é obrigatório.',`, essa segunda regra sobre escreve a primeira, pois é mais específica, a regra geral é essa `'O campo :attribute é obrigatório.'` para qualquer *required* e excepcionalmente para `email_form` essa `'O campo é obrigatório.'`, que é mais específica. Em resumo, você pode definir uma regra para um `campo.atributo` ou `atributo` no lado esquerdo da expressão e ao lado direito a mensagem, tudo isso dentro de um array e passado como segundo argumento do método validate.

#### :attribute
Esse parametro se for encontrado ao lado direito da expressão `:attribute` interpola-se com o nome do campo, ou seja, esse valor é interpolado pelo nome do campo no input, por exemplo: `'required' => 'O campo :attribute é obrigatório.'`, se o *name* for por exemplo *email_form*, ficará assim `'O campo email_form é obrigatório.'` e essa mesma lógica é aplicada a qualquer campo que se submeter a esse validator.

### Erros
#### Errors
    @if ($errors->any())
          <div class="alert alert-danger p-5 mt-5">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

Essa variável errors elá contém os erros, é através deles que você exibe ao usuário os erros que o usuário cometeu ao submeter variável e esses erros ficam dentro do objeto `$errors`.

`$errors->any()` => informa se o array contém erros ou não, se tiver esse método retornua *true*.

`$errors->all()` => retorna todos os erros pegos pelos validadores do laravel.

`$errors->has('[algum name de input de formulário]')` => Esse método retorna true caso exista algum erro associado ao input informado como argumento, esse argumento deve ser o `name` do *input*.

`$errors->first('[name de input de formulario]')` => Esse método retorna o primeiro erro pego informado pelo validador.

## Transformando dados em JSON
[Controller](app/Http/Controllers/FormularioController.php)
###### No controller
    public function api(){
        $todos = formulario::all();
        return $todos->toJson();
    }

ou 

    public function api(){
        $todos = formulario::all();
        return json_encode($todos);
    }

Essa função permite que ao invés de retornar uma view, retornar um *JSON*.
###### api.php
    Route::get('/', "App\Http\Controllers\FormularioController@api");

Todas as rotas registradas no [aquivo API](routes/api.php), estão dentro de */api*, no caso para acessar `http://localhost:porta/api`.

## Retornando códigos HTTP

    public function show($id = 0)
    {
        return response('OK',200);
    }

Ao invés de retornar uma *view*, você pode retornar um status HTTP para o cliente, útil caso a requisição seja feita planejando o uso do ajax, conforme visto aqui `return response('OK',200);`, sendo o primeiro argumento a mensagem a ser informado ao cliente e o segundo o código *HTTP*.

## Requisição AJAX
[home.blade.php](./resources/views/pages/home.blade.php)
###### Código
    function submit(isNeedToClearId){
            if(isNeedToClearId) document.getElementById('id').value = null;                
            const element = attr => document.getElementById(attr).value || null;   
            const id = element('id');    
            const body = new FormData();
            body.append('nome',element('nome'));
            body.append('email',element('email'));
            body.append('rua',element('rua'));
            body.append('cidade',element('cidade'));
            body.append('estado',element('estado'));
            if(!id){
                //Inserção       
                const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};         
                fetch('/api/um-para-um/',{method:'post',headers,body})
                    .then(console.log)
                    .catch(console.error)
                    .finally(getAll());                            
            }else{
                //Atualização  
                body.append('id',element('id'));
                body.append('_method','PUT')   
                const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};                              
                fetch(`/api/um-para-um/${id}`,{method:'post',headers,body})
                    .then(console.log)
                    .catch(console.error)
                    .finally(getAll());       
            }
            
        }

### Explicando 
Quando for fazer uma requisição ajax, ou fazer uso de formulários para outros verbos além do *GET* e *POST*, deve-se usar o `'X-CSFR-TOKEN`, que nada mais é que colocar o token no formulário para que ele seja válido no Laravel, além disso você deve passar o método desejado pelo atributo `_method`, devendo esse envio ser feito usando o método *POST*. 

### X-CSFR-TOKEN
Ou seja toda requisição que não seja *GET* deve conter em seu cabeçalho `'X-CSFR-TOKEN'`, esse token é necessário por motivos de segurança para evitar um ataque *CSFR*. Existe duas formas de se obter esse *token*, a primeira é através do blade `@csrf`, mas no caso do *ajax*, pode-se usar a função PHP, conforme visto aqui `csrf_token()`, conforme visto abaixo:

    const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};

No caso o resultado de `csrf_token()`, na expressão acima o *double mustache* na prática tem a mesma função que o *echo*, conforme visto aqui `'{{csrf_token()}}'`.

### @method('')
Nenhum formulário aceita um método diferente de *GET* ou *POST*, no caso se você quer fazer uso de qualquer outro método além desses, a requisição deve ser feito usando *POST* e dentro do formulário deve ter um campo chamado `name='_method' value='DELETE|PUT|PATCH|etc...'`, e com base nesse campo o *Laravel* deve fazer uma requisição com base no valor nesse campo, ou seja se por exemplo `name='_method' value='PUT'` essa requisição será feita usando o *PUT*, pois o *Laravel* vai levar em consideração o método passado no valor, porém se for fazer a requisição em *AJAX* temos:

    const body = new FormData();
    body.append('_method','PUT');
    body.append('id',element('id'));                
    const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};                              
    fetch(`/api/um-para-um/${id}`,{method:'post',headers,body})
        .then(console.log)
        .catch(console.error)
        .finally(getAll());       

No caso:

    body.append('_method','PUT');

Você deve incluir o *_method* cuja o valor seja o método ao qual deve ser a requisição, e claro, quando for fazer uma requisição com método diferente de *GET* a requisição será sempre *POST* `{method:'post',headers,body}`.

### Isso pode não funcionar

     function remove(id){
            let record = allData.filter(e => e.id == id);record = record[0];
            if(confirm(`Deseja Excluir ${record.nome}?`)){
                const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};
                fetch(`/api/um-para-um/${id}`,{method:'delete',headers})
                    .then(console.log)
                    .catch(console.error)
                    .finally(getAll());
            }
        }

Nessa requisição é feito pelo método *DELETE* direto sem passar o *@method*, vai funcionar, porém a requisição não terá corpo, no caso essa requisição deve funcionar, pois o laravel na exclusão usa o *ID* passado a *URL* para fazer a requisição. Porém se precisar de qualquer dado que não esteja na *URL*, não funcionaria, e é para poder aproveitar os dados do corpo da requisição que precisa usar a técnica com o *@method*.

## Seeders
Os *seeders* servem para popular tabelas no Laravel, no caso seria uma alternativa ao *TINKER*, porém você pode fazer isso usando algoritimos para isso, que é um grande diferencial dele. No caso seria aqui que seria programado a parte relacionada ao uso do *faker* para fazer os devidos testes. O seu funcionamento é relativamente simples:

### Criando um novo Seeder
    php artisan make:seeder [nome]

No terminal você deve digitar o comando acima e substituir `[nome]` pelo nome correspondente, recomenda-se a palavra *Seeder* após o nome, por exemplo *CategoriaSeeder*, *PessoaSeeder*, etc... Ao fazer isso:

    namespace Database\Seeders;
    use Illuminate\Database\Seeder;
    

    class [nome] extends Seeder
    {
        public function run()
        {              
            
        }
    }

É criado um classe nesse estilo acima, você pode importar o *DB* `use Illuminate\Support\Facades\DB;` caso você queira usar ele para popular alguma tabela. Você deve colocar toda a lógica dentro do método *run*. Se for usar a classe *DB* tem duas estratégias para isso:

### Primeira Estratégia: DB::table
[CategoriaSeeder](./database/seeders/CategoriaSeeder.php)

    public function run()
    {              
        DB::table('categorias')->insert(['nome' => 'ROUPAS']);        
        DB::table('categorias')->insert(['nome' => 'ELETRONICO']);
        DB::table('categorias')->insert(['nome' => 'PERFUME']);
        DB::table('categorias')->insert(['nome' => 'MOVEIS']);
    }

O `DB::table` vem do `use Illuminate\Support\Facades\DB;`. 

### Segunda estratégia: DB::metodos()
[ProdutoSeeder](./database/seeders/ProdutoSeeder.php)

    public function run()
    {
        DB::insert('insert into produtos (estoque,nome) values (?, ?)', [5, 'Camisa Polo']);
        DB::insert('insert into produtos (estoque,nome) values (?, ?)', [2, 'Televisor']);
        DB::insert('insert into produtos (estoque,nome) values (?, ?)', [1, 'Perfume feminino']);
        DB::insert('insert into produtos (estoque,nome) values (?, ?)', [4, 'Sofa de canto']);
    }

A segunda forma seria usar os métodos estáticos do próprio *DB*, no caso essa estratégia permite a digitação de uma query.

### Registrando no DatabaseSeeder.php    
[DatabaseSeeder](./database/seeders/DatabaseSeeder.php)

    namespace Database\Seeders;
    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder
    {        
        public function run()
        {
            $this->call(CategoriaSeeder::class);
            $this->call(ProdutoSeeder::class);        
        }
    }

Para que a **seeder** seja identificada, se faz necessário registrar as **seeders** criadas dentro do arquivo [DatabaseSeeder](./database/seeders/DatabaseSeeder.php), quando você for executar um comando para executar as seeders, é justamente esse arquivo que será lido, e é aqui `$this->call` que você informa as *seeders* a serem executadas. Nesse caso as duas *seeders* serão executadas. O método *call* aceita com argumento uma classe, e graças a estrutura do *Seeder* você pode colocar nesse arquivo [DatabaseSeeder](./database/seeders/DatabaseSeeder.php) as condições para as *Seeder* executar.

### Executando as Seeder
    `php artisan db:seed`

Esse comando acima, faz com que se execute todas a seeds criadas, segue aqui um exemplo: [EXEMPLO](./database/seeders/DatabaseSeeder.php)
## Erros possíveis
### Pagina expired error 419.
Toda vez que você ver esse erro, lembre-se de por o token no formulário, sem isso o laravel não permite o *submit*, para isso coloque isso `@csrf` dentro do seu arquivo blade no interior das tags `<form>`

### SQLSTATE[HY000]: General error: 1005 Can't create table
Se aparecer um erro parecido com esse:

      Illuminate\Database\QueryException 

    SQLSTATE[HY000]: General error: 1005 Can't create table `laravel`.`uso_motorista_veiculos` (errno: 150 "Foreign key constraint is incorrectly formed") (SQL: alter table `uso_motorista_veiculos` add constraint `uso_motorista_veiculos_veiculo_id_foreign` foreign key (`veiculo_id`) references `veiculos` (`id`))

    at C:\Users\crono\OneDrive\Área de Trabalho\php\Aulas\#LARAVEL\formulario\vendor\laravel\framework\src\Illuminate\Database\Connection.php:678
        674▕         // If an exception occurs when attempting to run a query, we'll format the error
        675▕         // message to include the bindings with SQL, which will make this exception a
        676▕         // lot more helpful to the developer instead of just the database's errors.
        677▕         catch (Exception $e) {
    ➜ 678▕             throw new QueryException(
        679▕                 $query, $this->prepareBindings($bindings), $e
        680▕             );
        681▕         }
        682▕

    1   C:\Users\crono\OneDrive\Área de Trabalho\php\Aulas\#LARAVEL\formulario\vendor\laravel\framework\src\Illuminate\Database\Connection.php:471
        PDOException::("SQLSTATE[HY000]: General error: 1005 Can't create table `laravel`.`uso_motorista_veiculos` (errno: 150 "Foreign key constraint is incorrectly formed")")

    2   C:\Users\crono\OneDrive\Área de Trabalho\php\Aulas\#LARAVEL\formulario\vendor\laravel\framework\src\Illuminate\Database\Connection.php:471
        PDOStatement::execute()

Tipo que diz que a chave estrangeira está formada incorretamente `errno: 150 "Foreign key constraint is incorrectly formed"`, vefique se o tipo da chave primaria com a chave estrangeira são os mesmos, a chave estrangeira deve ser o exato mesmo tipo da chave primária da outra tabela para funcionar, isso deve ser analisado nas migrations. Por exemplo:

[uso_motorista_veiculos](./database/migrations/2021_03_12_234553_create_uso_motorista_veiculos_table.php)

    Schema::create('uso_motorista_veiculos', function (Blueprint $table) {            
            $table->integer('veiculo_id')->unsigned();
            $table->foreign('veiculo_id')->references('id')->on('veiculos');
            $table->integer('motorista_id')->unsigned();
            $table->foreign('motorista_id')->references('id')->on('motoristas');
            $table->date('ultimo_uso')->nullable(true);
            $table->primary(['motorista_id','veiculo_id']);
            $table->timestamps();
        });

Ou seja, nessa migratio acima o **veiculo_id** deve o exato mesmo tipo que o *id* da tabela veiculo, conforme visto abaixo:

[2021_03_12_234426_create_veiculos_table](./database/migrations/2021_03_12_234426_create_veiculos_table.php)

    Schema::create('veiculos', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('placa');            
            $table->string('cor');
            $table->boolean('luxo');
            $table->timestamps();
        });

No caso `$table->integer('veiculo_id')->unsigned();` faz referência a `$table->integer('id')->unsigned()->autoIncrement();`, repare que as duas colunas são **unsigned** e **integer**, no caso do *autoincrement* se houver deve ser só no campo **PK** e não **FK**.

[2021_03_12_234508_create_motoristas_table](./database/migrations/2021_03_12_234508_create_motoristas_table.php)

    Schema::create('motoristas', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('nome');
            $table->string('cpf');            
            $table->timestamps();
        });

Aqui também se repete: `$table->integer('motorista_id')->unsigned();` faz referência a `$table->integer('id')->unsigned()->autoIncrement();`

## Eloquent um para um
### Entidade forte
Aqui temos um exemplo de relacionamento um para um. Inicialmente você precisa estabelecer uma entidade forte, que no caso é a [Cliente](app/Models/Cliente.php), nela é indicada um afunção para acessar a entidade fraca, como no exemplo abaixo:
    
    use HasFactory;
    function endereco(){
        return $this->hasOne(\App\Models\Endereco::class,'cliente_id');
    }

###### Migration
    Schema::create('clientes', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nome')->nullable(false);
        $table->string('email')->nullable(false);
        $table->timestamps();
    });
#### hasOne
Nessa função você faz o retorno usando o método **hasOne**, esse método exige como argumento, sendo o primeiro obrigatório a classe da entidade, nesse caso `\App\Models\Endereco::class` e o segundo o nome da coluna correspondente ao campo *id* da tabela fraca da relação, no caso o *cliente_id*. Ou seja a entidade `Endereco::class` tem como campo chave `cliente_id`. Esse segundo argumento é opcional, ou seja ele não é obrigatório caso você use o padrão de nomenclatura do *Laravel*, no caso se o nome do campo chave fosse **id** esse segundo argumento poderia ser omitido, mas como não é, e sim `cliente_id`, logo o mesmo deve ser informado no segundo argumento de **hasOne**. Essa função *hasOne* vem daqui, por isso precisa importar usando o **HasFactory**, conforme visto aqui: `use HasFactory;`

#### Increments
Esse é um campo de incremento e está marcado devido a isto `$table->increments('id');`, o método *increments* transforma em um campo de incremento, e devido a essa característica ela não é definida como chave primária aqui e sim na entidade fraca, nesse exemplo, uma vez que esse campo será usado como chave primária e estrangeira em outra tabela, ao qual tem um relacionamento fracom com essa.
### Entidade fraca
Aqui temos um exemplo de uma entidade que tem um relacionamento fraco com a classe acima, no caso é a classe [Endereco](app/Models/Endereco.php), segue o exemplo abaixo:

    class Endereco extends Model
    {
        protected $primaryKey = 'cliente_id';
        use HasFactory;
        function cliente(){
            return $this->belongsTo(Cliente::class,'cliente_id','id');
        }
    }

#### Informando a Chave primária
Na entidade acima, como a chave primária se chama *ID*, logo não se faz necessário informar isso, mas como isso não ocorre aqui, precisa inicialmente na própria entidade informar qual é o campo de chave primária e isso é feito aqui `protected $primaryKey = 'cliente_id';`.

#### belongsTo
Aqui ao invés de usar o *hasOne* usamos o *belongsTo*, ou seja essa entidade não tem uma outra entidade, ela pertece a outra entidade, esse método a ser rescrito vem de **HasFactory** igual ao *hasOne*. Então temos o uso da *belongsTo* aqui `return $this->belongsTo(Cliente::class,'cliente_id','id');`, nesse método podemos passar até 3 argumentos, podendo o segundo e o terceiro argumento ser omitido, caso ambos as entidades tenham como campo chave o nome *id*. O primeiro argumento é a entidade ao qual pertence, que no caso é essa `Cliente::class`, o segundo o campo *ID* da própria entidade, nesse caso o campo chave da tabela é esse, o *cliente_id* conforme feito na migration também:
###### Migration da entidade fraca

    Schema::create('enderecos', function (Blueprint $table) {
        $table->integer('cliente_id')->unsigned();

        $table->foreign('cliente_id')
        ->references('id')->on('clientes')
        ->onUpdate('cascade')->onDelete('cascade');

        $table->primary('cliente_id');
        $table->string('estado');
        $table->string('cidade');
        $table->string('rua');
        $table->timestamps();
    });

Repare que a chave estrangeira também é a chave primária e isso pode ser visto aqui `$table->primary('cliente_id');` e aqui `$table->foreign('cliente_id')->references('id')->on('clientes')->onUpdate('cascade')->onDelete('cascade');`, sendo esse campo sendo definido aqui `$table->integer('cliente_id')->unsigned();`. Por fim no campo **belongsTo** existe um terceiro argumento, conforme visto aqui `return $this->belongsTo(Cliente::class,'cliente_id','id');`, nesse caso o *id* seria o campo chave ao qual possuí um relacionamento forte com essa entidade.

### Para resumir
>Ambos os métodos **hasOne** e **belongsTo** vem da superclasse **HasFactory** que vem de `use Illuminate\Database\Eloquent\Factories\HasFactory;`. O **hasOne** deve ser colocada na classe ao qual possuí o relacionamento *(O método que possuí o relacionamento forte)*. Como argumento o **hasOne** pede a classe que possuí a parte fraca da relação no primeiro argumento, podendo ter o segundo argumento omitido, caso o Modelo segue o padrão de nomenclatura do Laravel. O **belongsTo** é usado na entidade ao qual é posse de um relacionamento, ou seja na entidade fraca, esse método aceita três argumentos, a classe ao qual ela está contida, o campo chave da entidade fraca e o nome do campo chave dessa entidade.
###### Importando Modelos
    use App\Models\Cliente as ModelCliente;
    use App\Models\Endereco;
###### salvando
     public function store(Request $request)
    {
        $cliente = new ModelCliente();
        $cliente->nome = $request->input('nome');
        $cliente->email = $request->input('email');
        $cliente->save();

        $endereco = new Endereco();
        $endereco->rua = $request->input('rua');
        $endereco->cidade = $request->input('cidade');
        $endereco->estado = $request->input('estado');        

        $cliente->endereco()->save($endereco);
        return response('Created',201);
    }

Para salvar (criar dados novos) você pode fazer uso do relacionamento, no caso o método *store* acima cria um novo registro, nesse caso o **endereco()**  [vem daqui](#entidade-forte), repareque esse método faz um retorno e é com base nesse retorno que é feito o relacionamento e o *Laravel* entende o *endereço* como parte do relacionamento, ao passo que dentro do save é colocado o objeto modelo contendo os dados a serem inseridos, no caso é um objeto do tipo entidade fraca, conforme visto aqui `$cliente->endereco()->save($endereco);` e então retornado uma mensagem de que foi inserido `return response('Created',201);`, para exemplificar> `$[entidade forte]->[nome do metodo que retorna hasOne]()->save($[instancia da entidade fraca com os dados]);`
###### atualizando
    public function update(Request $request, $id)
    {
            $clientes = ModelCliente::with('endereco')->get();         
            $cliente = $clientes->find($id);                        
            if($cliente){                
                $cliente->nome = $request->input('nome');                
                $cliente->email = $request->input('email');                                
                $cliente->update();
                                
                $endereco = $cliente->endereco; 
                $endereco->cliente_id = $id;               
                $endereco->rua = $request->input('rua');
                $endereco->cidade = $request->input('cidade');
                $endereco->estado = $request->input('estado');                
                $cliente->endereco->update();                

                return response('Updated',202);
            }else{
                return response('Not Found',404);
            }            
    }

Aqui estamos atualizando, inicialmente estamos pegando de maneira *eager* aqui `$clientes = ModelCliente::with('endereco')->get();`, esse `'endereco'` [vem daqui](#entidade-forte), ou seja como string você deve informar o método que retorna o *hasOne*. Por padrão o carregamento é *lazy*, logo os dados do relacionamento não vêm, porém se carregar de maneira *eager*, como feito aqui, o carregamento é feito junto com o relacionamento, logo como o carregamento foi *eager* não precisa informar instancia no *update* conforme visto aqui `$cliente->endereco->update();` e retornado caso a atualização ocorra `return response('Updated',202);`.
###### excluindo
    public function destroy($id)
    {
        $clientes = ModelCliente::with('endereco')->get();         
        $cliente = $clientes->find($id);
        if($cliente){
            $cliente->delete();
            return response('Deleted',204);
        }else{
            return response('Not Found',404);
        }        
    }

Para excluir, usa o mesmo pricípio usado na atualização, porém isso funciona, porque o carregamento é **eager** `$clientes = ModelCliente::with('endereco')->get();`, de toda forma como existe cascade on *update* e *delete* ao excluir cliente se exclui o endereço junto, conforme [visto aqui](#migration-da-entidade-fraca). Depois de exluir retorna o estatus *204* `return response('Deleted',204);`.
## Eloquent um para muitos
[ 1 Categoria](./app/Models/Categoria.php) para ['N' Produto](./app/Models/Produto.php).
### Entidade dominante 

    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Categoria extends Model
    {    
        use HasFactory;
        public function produtos(){
            return $this->hasMany(Produto::class);
        }
    }

O método *hasMany* vem da mesma origem do *hasOne*, ou seja de *HasFactory*, além disso segue a mesma lógica, no caso nesse método é passado apenas a classe, devido a essa *Entidade* seguir o padrão de nomenclatura do *Laravel*, logo não precisa que se informe qual é o campo *id*, o laravel já deduz nesse caso que o campo chave se chama *ID*.

### Entidade dominada

    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Produto extends Model
    {
        use HasFactory;
        public function categoria(){
            return $this->belongsTo(Categoria::class);
        }
    }

Na classe dominada, tanto no *1 para 1* como em relacionamentos *1 para N*, usa na classe dominada o método *belongsTo()*. Novamente, como essa classe segue o padrão de nomenclatura do *Laravel*, o segundo e o terceiro argumento podem ser omitido.

### Sobre o Controller
Você também pode  conforme visto nesse exemplo:[ProdutoCategoriaController](./app/Http/Controllers/ProdutoCategoriaController.php), ou seja você pode, se quiser não usar o relacionamento do *Eloquent*, conforme ilustrado nesse controller, associando o *ID* da classe dominante na classe dominada.

## Eloquent - Muitos para Muitos
### Modelos - Many To Many
[Motorista](./app/Models/Motorista.php)

[Veiculo](./app/Models/Veiculo.php)

[UsoMotoristaVeiculo](./app/Models/UsoMotoristaVeiculo.php)
### Classe Motorista
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Motorista extends Model
    {
        protected $table = "motoristas";
        protected $primaryKey = "id";

        use HasFactory;

        public function veiculos(){
            return $this->belongsToMany(Veiculo::class,UsoMotoristaVeiculo::class)->withPivot('ultimo_uso');
        }
    }

Quando você faz o relacionamento *M* para *N*, você irá precisar de uma terceira entidade para intermediar essa relação entre **M** e **N**, para isso usamos o método `belongsToMany` do `Illuminate\Database\Eloquent\Factories\HasFactory;`. Essa classe aceita dois argumentos, o primeiro é o modelo que faz parte do outro lado da relação, no caso [Classe Veículo](#classe-veículo), e o segundo argumento é justamente essa classe que intermedia essa relação muito para muito dessas duas classes, no caso [UsoMotoristaVeiculo](#classe-usomotoristaveiculo).

### withPivot
Esse método é importante caso você queira incluir campos da tabela intermediária nessa relação, por exemplo com o `belongsToMany` você obtem todos os relacionamentos da outra classe, mas com o *pivot* você também terá acesso aos campos dessa tabela intermediaria, no caso essa classe intermediaria tem uma coluna chamada *ultimo_uso* e essa será inclusa ao relacionamento, dentro de um objeto chamado *pivot*.

### Classe Veículo
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Veiculo extends Model
    {
        protected $table = "veiculos";
        protected $primaryKey = "id";
        
        use HasFactory;

        public function motoristas(){
            return $this->belongsToMany(Motorista::class,UsoMotoristaVeiculo::class)->withPivot('ultimo_uso');
        }
    }

Acima estamos configurando o outro lado da relação, é válido ressaltar que se você segue o padrão de nomenclatura, não se faz necessário incluir `$table` e o `$primaryKey`.
### Classe UsoMotoristaVeiculo
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class UsoMotoristaVeiculo extends Model
    {
        protected $table = "uso_motorista_veiculos";
        protected $primaryKey = ["veiculo_id","motorista_id"];
        use HasFactory;
    }

Essa entidade usa como chave primária duas chaves estrangeiras, conforme visto aqui `protected $primaryKey = ["veiculo_id","motorista_id"];`, sendo que *veiculo_id* referente a tabela [veiculos](#classe-veículo) e *motorista_id* que se refere a tabela [motoristas](#classe-motorista).

###### Veiculos - ManyToMany
    ...
        Schema::create('veiculos', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('placa');            
            $table->string('cor');
            $table->boolean('luxo');
            $table->timestamps();
        });
    ...

###### Motoristas - ManyToMany
    ...
        Schema::create('motoristas', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('nome');
            $table->string('cpf');            
            $table->timestamps();
        });
    ...

###### UsoMotoristaVeiculos
    ...
        Schema::create('uso_motorista_veiculos', function (Blueprint $table) {            
            $table->integer('veiculo_id')->unsigned();
            $table->foreign('veiculo_id')->references('id')->on('veiculos');
            $table->integer('motorista_id')->unsigned();
            $table->foreign('motorista_id')->references('id')->on('motoristas');
            $table->date('ultimo_uso')->nullable(true);
            $table->primary(['motorista_id','veiculo_id']);
            $table->timestamps();
        });
    ...

Nessa migration estamos criando uma tabela com chave composta `$table->primary(['motorista_id','veiculo_id']);``.

### Controller Básico

    class ManyController extends Controller
    {
        public function index(){
            $title = "Many to Many";
            return view('ntom.home',compact(['title']));
        }

        public function getAllVeiculo(){
            $veiculos = Veiculo::with('motoristas')->get();
            return response($veiculos->toJson(),200);
        }

        public function getAllMotorista(){
            $motoristas = Motorista::with('veiculos')->get();
            return response($motoristas->toJson(),200);
        }        
    }

Até agora estamos usando a mesma estratégia **EAGER** que foi usanda no *1* para *N*. Porém dentro de veículo por exemplo `$veiculos = Veiculo::with('motoristas')->get();`, terá um array de [Motoristas](#classe-motorista), e dentro desse array dentro de cada [Motoristas](#classe-motorista), você também terá um objeto chamado [pivot](#withpivot) dentro de cada elemento desse array, e o mesmo vale para a classe [Motoristas](#classe-motorista) que contém um array de [Veículos](#classe-veículo) que também contém um [pivot](#withpivot) dentro de cada elemento.

### Associação Básica
[ManyController](./app/Http/Controllers/ManyController.php)
###### Associação Motoristas -> Veiculos
    public function assocMotorista(Request $request, $id){
        try{
            $motorista = Motorista::find($id);
            $veiculo_id = $request->input('id');            
            $motorista->veiculos()->attach($veiculo_id);
            $motorista->save();
            return response('ASSOCIATED',202);
        }catch(Exception $e){
            return response($e->getMessage(),500);
        }
    }

###### Associação Veiculos -> Motoristas
    public function assocVeiculo(Request $request, $id){
        try{           
            $veiculo = Veiculo::find($id);
            $motorista_id = $request->input('id');
            $veiculo->motoristas()->attach($motorista_id);
            $veiculo->save();
            return response('ASSOCIATED',202);
        }catch(Exception $e){
            return response($e->getMessage(),500);
        }
    }

A lógica se encontra aqui `$motorista->veiculos()->attach($veiculo_id);` e `$veiculo->motoristas()->attach($motorista_id);`, no caso `$[tabela dona do relacionamento]->[retorno do metodo belongsToMany em forma de metodo]()->attach([id da outra tabela]` ou `->attach([id da outra tabela => [array com campos e os seus valores da tabela intermediária]])`. O método *attach* com apenas um parametro recebe apenas o id da outra tabela no relacionamento, porém quando recebe um array, esse array que deve conter em forma como chave o *ID* da outra parte da relação cujo o valor seja um array contendo todas informações dos campos.

### Associação mais avançada

###### Motorista
    ...
        $motorista->veiculos()->attach([$veiculo_id => ["ultimo_uso" => date("Y-m-d")]]);
    ...    

**Nesse segundo exemplo `->attach([$veiculo_id => ["ultimo_uso" => date("Y-m-d")]]);` você usa o id da tabela veiculo associando um array com os dados da tabela intermediaria.**
###### Veiculo
    ...
        $veiculo->motoristas()->attach([$motorista_id => ["ultimo_uso" => date("Y-m-d")]]);
    ...

**Nesse segundo exemplo `->attach([$motorista_id => ["ultimo_uso" => date("Y-m-d")]]);` você usa o id da tabela veiculo associando um array com os dados da tabela intermediaria.**

### Desassociando

    public function desassociar(Request $request){
        try{
            $veiculo_id = $request->input('veiculo_id');
            $motorista_id = $request->input('motorista_id');
            $type = $request->input('type');
            if($type === "motorista"){
                $veiculo = Veiculo::find($veiculo_id);
                $veiculo->motoristas()->detach([$motorista_id]);
            }else if($type === "veiculo"){
                $motorista = Motorista::find($motorista_id);
                $motorista->veiculos()->detach([$veiculo_id]);
            }else{
                return response('Invalid Operation',401);
            }
        }catch(Exception $e){
            return response($e->getMessage(),500);
        }
    }

No caso para fazer a desassociação, conforme visto aqui `$veiculo->motoristas()->detach([$motorista_id]);` e aqui `$motorista->veiculos()->detach([$veiculo_id]);`, a lógica é semelhanet ao método `attach`, porém diferente desse, esse método faz a operação contrária que é romper vínculos e além disso o método `detach` aceita como argumento um array com ids da entidade alvo da relação. Por exemplo aqui `$veiculo->motoristas()->detach([$motorista_id]);` estamos fazendo a desassociação através do veículo, logo o argumento que deve ser passado no método não deve ser os *ids* do veículo e sim os *ids* do motorista que é o outro lado do relacionamento com o motorista.