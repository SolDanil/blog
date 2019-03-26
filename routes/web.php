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

Route::get('/git_user/{name}', 'MyControler@show');

Route::get('/get_users/{ask}', 'MyControler@get_users');
Route::get('/request/{name}', 'MyControler@request_users');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
