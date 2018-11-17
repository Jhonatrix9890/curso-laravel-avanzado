<?php

namespace App\Charts;

use App\Pelicula;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use DB;


class PeliculaChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
        $this->buildChart();
    }
    //bar
    //line
    //pie

    private function buildChart()
    {
        $peliculas = Pelicula::select('anio', DB::raw('count(*) as total'))->orderBy('anio')->groupBy('anio')->get();
        $this->dataset('Películas', 'pie', $peliculas->pluck('total'))->options(
            [
                'borderColor' => 'blue',
                'backgroundColor' => '#01DFD7'
            ]
        );
        $this->labels($peliculas->pluck('anio'));
    }

}
 