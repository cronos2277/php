<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', "App\Http\Controllers\FormularioController@api");
Route::delete('/{id}', "App\Http\Controllers\FormularioController@remove");

Route::get('/um-para-um/{id?}','App\Http\Controllers\Cliente@show');
Route::post('/um-para-um/','App\Http\Controllers\Cliente@store');
Route::delete('/um-para-um/{id}','App\Http\Controllers\Cliente@destroy');
Route::put('/um-para-um/{id}','App\Http\Controllers\Cliente@update');

Route::get('/um-para-muitos/p','App\Http\Controllers\ProdutoCategoriaController@todosProdutos');
Route::get('/um-para-muitos/c','App\Http\Controllers\ProdutoCategoriaController@todasCategorias');
Route::post('/um-para-muitos/c','App\Http\Controllers\ProdutoCategoriaController@adicionarCategoria');
Route::delete('/um-para-muitos/c/{id}','App\Http\Controllers\ProdutoCategoriaController@removerCategoria');
Route::put('/um-para-muitos/c/{id}','App\Http\Controllers\ProdutoCategoriaController@atualizarCategoria');
Route::put('/um-para-muitos/p/c/{id}','App\Http\Controllers\ProdutoCategoriaController@atualizarProdutoCategoria');
