<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas da web
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas da web para seu aplicativo. Estes
| as rotas são carregadas pelo RouteServiceProvider dentro de um grupo que
| contém o grupo de middleware "web". Agora crie algo ótimo!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

//Exemplo basico de rota
Route::get('/rotaexemplo', function () {
    echo "ola mundo,sem parametro";
});

//Exemplo com um único parametro opcinal
Route::get('/rotaexemplo/{param1?}', function ($par=null) {
    return "ola mundo, parametro: ".$par;
});

//Exemplo com mais parametros
Route::get('/rotaexemplo/{param1}/{param2}', function ($p,$q) {
    echo "ola mundo, parametro: ".$p.", ".$q;
});

//Exemplo de rotas com regras
Route::get('/numero/{n}',function($n){
    echo '<h1>O Número da URL é: '.$n.'</h1>';
})->where(
    'n','[0-9]+'
);

//grupos de rotas
Route::group(['prefix' => 'route'], function () {
    
    Route::get('{nome}/{repetir?}', function ($nome,$repetir = 1) {
        for($i = 0;$i<$repetir;$i++):
            echo "<h3>$nome</h3>";
        endfor;
    })
    ->where('nome','[A-z\s\-]+')
    ->where('repetir','[\d]+')
    ;

    Route::get('/', function () {
        return view('rotas');
    });

});

Route::get('exemplo/{n1}/{n2}','App\Http\Controllers\classe@metodo');

Route::resource('controller', 'App\Http\Controllers\resource');

Route::get('view/{n}','App\Http\Controllers\view@view_simples');
Route::get('view','App\Http\Controllers\view@template');
Route::get('view_avancado/{n?}','App\Http\Controllers\view_avancado@response')
->name('avancado')->where('n','\d');