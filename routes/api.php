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

Route::get('status',        ['as' => 'api.status',        'uses' => 'ApiController@status']);
Route::get('uptimerobot',   ['as' => 'api.uptimerobot',   'uses' => 'UpTimeRobotController@index']);
Route::get('nisam',         ['as' => 'api.nisam',         'uses' => 'NisamController@index']);
Route::get('quote',         ['as' => 'api.quote',         'uses' => 'QuoteController@index']);
Route::get('currency',      ['as' => 'api.currency',      'uses' => 'CurrencyController@index']);
Route::get('whatsdone',     ['as' => 'api.whatsdone',     'uses' => 'WhatsDoneController@index']);
Route::get('weather',       ['as' => 'api.weather',       'uses' => 'WeatherController@index']);
Route::get('dilbert',       ['as' => 'api.dilbert',       'uses' => 'DilbertController@index']);
Route::get('version',       ['as' => 'api.version',       'uses' => 'VersionController@index']);
Route::get('eurojackpot',   ['as' => 'api.eurojackpot',   'uses' => 'EuroJackpotController@index']);
Route::get('optimizeleads', ['as' => 'api.optimizeleads', 'uses' => 'OptimizeLeadsController@index']);
Route::get('optimizehub',   ['as' => 'api.optimizehub',   'uses' => 'OptimizeHubController@index']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
