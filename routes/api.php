<?php

use Illuminate\Http\Request;

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

Route::get('uptimerobot', ['as' => 'api.uptimerobot', 'uses' => 'UpTimeRobotController@index']);
Route::get('nisam',       ['as' => 'api.nisam',       'uses' => 'NisamController@index']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
