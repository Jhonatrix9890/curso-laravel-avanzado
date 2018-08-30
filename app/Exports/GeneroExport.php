<?php

namespace App\Exports;

use App\Genero;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GeneroExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Genero::all();
    }

    public function title(): string 
    {
        return 'Generos';

    }

    public function headings(): array
    {
        return[
            'ID',
            'Nombre',       
            'Fecha de creación',
            'última actualizacion',            

        ];

    }
}
