<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeliculasActoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peliculas_actores', function (Blueprint $table) {
            $table->increments('idPelAct');
            $table->integer('idPelicula');
            $table->integer('idActor');
            $table->foreign('idPelicula')->references('idPelicula')->on('peliculas');
            $table->foreign('idActor')->references('idActor')->on('actores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas_actores');
    }
}
