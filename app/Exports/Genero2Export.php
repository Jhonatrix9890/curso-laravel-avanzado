<?php

namespace App\Exports;

use App\Genero;
use Maatwebsite\Excel\Concerns\FromCollection;

class Genero2Export implements FromCollection
{
    public function sheets(): array
    {
        $generos = Genero::has('peliculas')->get();
        $sheets = [];

        foreach ($generos as $gen) {
            $sheets[] = new GeneroPerPeliculaSheet($ge);
        }

        return $sheets;
    }
}
