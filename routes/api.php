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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


    
Route::get('movie/{idPelicula}', 'PeliculaController@findMovie');
Route::get('api_actores', 'ServiceController@getActores');
Route::get('todos', 'ServiceController@getTodos');
Route::get('actores', 'ActorController@index_api');
Route::post('actores', 'ActorController@store');

