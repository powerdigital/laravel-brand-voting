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

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

//Auth::routes();

Route::get('/', 'IndexController@index');

Route::get('/category/{category}', 'IndexController@index');
Route::get('/category/{category}/page/{page}', 'IndexController@index');

Route::post('/voting/add', 'VotingController@add');

Route::post('/get-auth-code', 'Auth\LoginController@getAuthCode');
Route::post('/authenticate', 'Auth\LoginController@authenticate');
