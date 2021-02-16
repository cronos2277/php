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

Route::get('/', 'App\Http\Controllers\FormularioController@index')->name('index');
Route::get('create','App\Http\Controllers\FormularioController@create');
Route::get('edit/{id}','App\Http\Controllers\FormularioController@edit');
Route::post('store', 'App\Http\Controllers\FormularioController@store');
Route::put('update/{id}', 'App\Http\Controllers\FormularioController@update');
Route::get('destroy/{id}','App\Http\Controllers\FormularioController@destroy');