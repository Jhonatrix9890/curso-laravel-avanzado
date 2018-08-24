<?php

use Illuminate\Database\Seeder;

class PeliculasGenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Pelicula::class, 80)->create()->each(function($p)
    {
        //codigo detach
        $p->generos()->attach(factory(App\Genero::class,3)->create());
    });
    }
}
