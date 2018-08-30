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
Route::get('api_actores', 'ServiceController@getActores');

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
            Route::get("reportes", "ReporteController@index")->name('reportes.index');
            Route::get("passport", "PassportController@index")->middleware('role:admin')->name('passport.index');
            Route::resource("peliculas", "PeliculaController")->except(['store', 'update', 'distroy']) ;
            Route::resource("generos", "GeneroController")->except(['store', 'update', 'distroy']);
            Route::resource("actores", "ActorController")->except(['store', 'update', 'distroy']);
            Route::resource("usuarios","UserController")->except(['store', 'update', 'distroy', 'create', 'edit'])
            ->middleware('role:admin');
            Route::get('settings', 'UserController@settings')->name('settings');
            Route::post('change_password', 'UserController@change_password')->name('settings.store');
        });
    });
    Route::group(["middleware" => "auth"], function () {       
        Route::resource("peliculas","PeliculaController")->only(['store', 'update', 'distroy']);
        Route::resource("actores","ActorController")->only(['store', 'update', 'distroy']);
        Route::resource("generos","GeneroController")->only(['store', 'update', 'distroy']);
        Route::resource("usuarios","UserController")->only(['store', 'update', 'distroy'])
        ->middleware('role:admin');
        
        Route::post("generos/{id}/restore","GeneroController@restore")->name("generos.restore");
        Route::post("generos/{id}/trash","GeneroController@trash")->name("generos.trash");
    
        Route::post("actores/{id}/restore","ActorController@restore")->name("actores.restore");
        Route::post("actores/{id}/trash","ActorController@trash")->name("actores.trash");
    
        Route::post("peliculas/{id}/restore","PeliculaController@restore")->name("peliculas.restore");
        Route::post("peliculas/{id}/trash","PeliculaController@trash")->name("peliculas.trash");

        Route::group(["prefix" => "reportes"], function () {       
            Route::get("usuarios","ReporteController@reporteUsuarios")->name('reportes.usuarios');
            Route::get("usuarios/excel","ReporteController@reporteUsuariosExcel")->name('reportes.usuarios.excel');
            Route::get("generos/excel","ReporteController@reporteGeneroExcel")->name('reportes.generos.excel');
            Route::get("peliculas/excel","ReporteController@reportePeliculasExcel")->name('reportes.peliculas.excel');
            Route::get("generos_peliculas/excel","ReporteController@reporteGenerosPorPeliculasExcel")->name('reportes.generos_peliculas.excel');
            


            
        });    
    
            


    });


