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
    });

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
### Artisan
#### Executando um projeto no laravel
    php artisan serve
#### Exibindo listas de todas as rotas
    php artisan route:list
## Instalação
## Problema com o PHP ini ou a versão do PHP
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