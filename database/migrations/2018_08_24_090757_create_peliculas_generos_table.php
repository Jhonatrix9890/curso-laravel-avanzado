<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeliculasGenerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peliculas_generos', function (Blueprint $table) {
            $table->increments('idPelGen');
            $table->integer('idPelicula');
            $table->integer('idGenero');
            $table->foreign('idPelicula')->references('idPelicula')->on('peliculas');
            $table->foreign('idGenero')->references('idGenero')->on('generos');
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
        Schema::dropIfExists('peliculas_generos');
    }
}
