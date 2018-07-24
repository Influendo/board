<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*
Route::get('/', function () {
    return redirect()->to('board/influendo');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('board/{uid}', ['as', 'boards.show', 'uses' => 'BoardsController@show']);
*/

Route::get('/', ['as', 'boards.show', 'uses' => 'BoardsController@show']);

Route::get('/clear-cache/{key}', 'BoardsController@clearCache');
