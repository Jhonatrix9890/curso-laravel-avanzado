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

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);


    Route::group(["middleware" => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], 'prefix' => LaravelLocalization::setLocale()], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Auth::routes();
        Route::get('/', function () {
            return view('welcome');
        });
        Route::group(["middleware" => "auth"], function () {
            Route::resource("peliculas", "PeliculaController")->except(['store', 'update', 'distroy']);
            Route::resource("generos", "GeneroController")->except(['store', 'update', 'distroy']);
            Route::resource("actores", "ActorController")->except(['store', 'update', 'distroy']);
        });
    });
    Route::group(["middleware" => "auth"], function () {

        Route::resource("peliculas","PeliculaController")->only(['store', 'update', 'distroy']);
        Route::resource("actores","ActorController")->only(['store', 'update', 'distroy']);
        Route::resource("generos","GeneroController")->only(['store', 'update', 'distroy']);

        Route::post("generos/{id}/restore","GeneroController@restore")->name("generos.restore");
        Route::post("generos/{id}/trash","GeneroController@trash")->name("generos.trash");
    
        Route::post("actores/{id}/restore","ActorController@restore")->name("actores.restore");
        Route::post("actores/{id}/trash","ActorController@trash")->name("actores.trash");
    
        Route::post("peliculas/{id}/restore","PeliculaController@restore")->name("peliculas.restore");
        Route::post("peliculas/{id}/trash","PeliculaController@trash")->name("peliculas.trash");
    });


