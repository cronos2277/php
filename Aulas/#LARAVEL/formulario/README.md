# Formulário no Laravel

## Pagina expired error 419.
Toda vez que você ver esse erro, lembre-se de por o token no formulário, sem isso o laravel não permite o *submit*, para isso coloque isso `@csrf` dentro do seu arquivo blade no interior das tags `<form>`

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

Todas as rotas registradas no [aquivo API](routes/api.php), estão dentro de */api*, no caso para acessar `http://localhost:porta/api`