<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/produtos','App\Http\Controllers\ControladorProduto@index');
Route::get('/categorias','App\Http\Controllers\ControladorCategoria@index');
Route::get('/categorias/novo','App\Http\Controllers\ControladorCategoria@create');
Route::post('/categorias','App\Http\Controllers\ControladorCategoria@store');
Route::get('/categorias/apagar/{id}','App\Http\Controllers\ControladorCategoria@destroy');
Route::get('/categorias/editar/{id}','App\Http\Controllers\ControladorCategoria@edit');
Route::post('/categorias/{id}','App\Http\Controllers\ControladorCategoria@update');

