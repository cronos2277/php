<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas API
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar rotas de API para seu aplicativo. Estes
| as rotas são carregadas pelo RouteServiceProvider dentro de um grupo que
| é atribuído ao grupo de middleware "api". Aproveite a construção de sua API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

