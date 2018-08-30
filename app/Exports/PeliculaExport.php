<?php

namespace App\Exports;

use App\Pelicula;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PeliculaExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        $years = Pelicula::groupBy('anio')->orderBy('anio')->get(['anio']);
        $sheets = [];

        foreach ($years as $y) {
            $sheets[] = new PeliculaPerYearSheet($y->anio);
        }

        return $sheets;
    }

}
