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
    return view('welcome');
});

Route::get('/middleware',"\App\Http\Controllers\ControladorController@index")
    ->middleware(\App\Http\Middleware\Primeiro::class)
    ->middleware('segundo');

Route::get('/controle',"\App\Http\Controllers\IndexCtrl@index")
    ->middleware(
        "\App\Http\Middleware\First:1",
        "\App\Http\Middleware\Second:2,3",
        "\App\Http\Middleware\Third"
    );
Auth::routes();

Route::get('/home', '\App\Http\Controllers\HomeController@index')->name('home');

Route::get('/admin','\App\Http\Controllers\AdminController@index')->name('admin.dashboard');
Route::get('/admin/login','\App\Http\Controllers\AdminController@login')->name('admin.login');
Route::post('/admin/login','\App\Http\Controllers\AdminController@login')->name('admin.login.submit');