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
