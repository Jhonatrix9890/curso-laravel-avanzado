<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Pelicula;

class FindMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:movie {--y | year= : Año de la película} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca películas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $year=$this->option('year');
        $header=["Título","Año","Duración"];
        if($year == null) {
            $year = date('Y');
        }
        $peliculas=Pelicula::select('titulo','anio','duracion')->where('anio',$year)->get();
        $this->table($header,$peliculas);
    }
}
