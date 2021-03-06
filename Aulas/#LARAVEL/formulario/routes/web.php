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
Route::get('/','App\Http\Controllers\FormularioController@index');
Route::get('/show', 'App\Http\Controllers\FormularioController@show')->name('index');
Route::get('create','App\Http\Controllers\FormularioController@create');
Route::get('edit/{id}','App\Http\Controllers\FormularioController@edit');
Route::post('store', 'App\Http\Controllers\FormularioController@store');
Route::put('update/{id}', 'App\Http\Controllers\FormularioController@update');
Route::get('destroy/{id}','App\Http\Controllers\FormularioController@destroy');
Route::get('um-para-um','App\Http\Controllers\Cliente@index')->name('1to1');
Route::get('um-para-muitos','App\Http\Controllers\ProdutoCategoriaController@index')->name('1toN');
Route::get('muitos-para-muitos','App\Http\Controllers\ManyController@index')->name('NtoN');