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
