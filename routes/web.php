<?php

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

//登陆
Route::get('login','User\IndexController@loginView');
Route::post('login','User\IndexController@loginAction');
Route::post('api/login','User\IndexController@apiLogin');

//注册
Route::get('register','User\IndexController@registerView');
Route::post('register','User\IndexController@registerAction');


Route::get('center','User\IndexController@center')->middleware('check.login');
