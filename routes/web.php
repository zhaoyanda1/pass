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


//登陆
Route::get('login','Login\LoginController@login');
Route::post('login','Login\LoginController@loginAction');
Route::post('login/api','Login\LoginController@apiLogin');
//注册
Route::get('reg','Login\LoginController@reg');
Route::post('/register','Login\LoginController@registerAction');
Route::get('center','Login\LoginController@center')->middleware('check.login');
