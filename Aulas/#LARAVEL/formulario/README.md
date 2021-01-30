# Formulário no Laravel

## Pagina expired error 419.
Toda vez que você ver esse erro, lembre-se de por o token no formulário, sem isso o laravel não permite o *submit*, para isso coloque isso `@csrf` dentro do seu arquivo blade no interior das tags `<form>`

## Validando formulários
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