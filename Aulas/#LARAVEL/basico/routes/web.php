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
});

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