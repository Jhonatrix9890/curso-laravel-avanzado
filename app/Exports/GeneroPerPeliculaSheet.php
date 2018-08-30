<?php

namespace App\Exports;

use App\Genero;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class GeneroPerPeliculaSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithMapping
{

    private $genero;

    public function __construct(Genero $genero)
    {
        $this->genero = $genero;
    }

    public function map($pelicula): array
    {
        return [
            $pelicula->idPelicula,
            $pelicula->titulo,
            $pelicula->duracion,
            $pelicula->anio,
        ];
    }

    public function collection()
    {
        return $this->genero->peliculas()->orderBy('titulo')->get();
    }

    public function title(): string
    {
        return $this->genero->nombre;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Duración',
            'Año',
        ];
    }


}
