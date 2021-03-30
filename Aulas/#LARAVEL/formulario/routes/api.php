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
Route::put('/um-para-muitos/p/e/{id}','App\Http\Controllers\ProdutoCategoriaController@atualizarProdutoEstoque');
Route::put('/um-para-muitos/p/n/{id}','App\Http\Controllers\ProdutoCategoriaController@atualizarProdutoNome');
Route::delete('/um-para-muitos/p/{id}','App\Http\Controllers\ProdutoCategoriaController@removerProduto');
Route::post('/um-para-muitos/p','App\Http\Controllers\ProdutoCategoriaController@adicionarProduto');

Route::get('muitos-para-muitos/m','App\Http\Controllers\ManyController@getAllMotorista');
Route::post('muitos-para-muitos/m','App\Http\Controllers\ManyController@newMotorista');
Route::put('muitos-para-muitos/m/{id}','App\Http\Controllers\ManyController@updateMotorista');
Route::patch('muitos-para-muitos/m/{id}','App\Http\Controllers\ManyController@assocMotorista');
Route::delete('muitos-para-muitos/m/{id}','App\Http\Controllers\ManyController@deleteMotorista');
Route::get('muitos-para-muitos/v','App\Http\Controllers\ManyController@getAllVeiculo');
Route::post('muitos-para-muitos/v','App\Http\Controllers\ManyController@newVeiculo');
Route::put('muitos-para-muitos/v/{id}','App\Http\Controllers\ManyController@updateVeiculo');
Route::patch('muitos-para-muitos/v/{id}','App\Http\Controllers\ManyController@assocVeiculo');
Route::delete('muitos-para-muitos/v/{id}','App\Http\Controllers\ManyController@deleteVeiculo');
Route::delete('muitos-para-muitos/d','App\Http\Controllers\ManyController@desassociar');

