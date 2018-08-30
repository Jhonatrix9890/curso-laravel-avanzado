<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class UserExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

    public function title(): string 
    {
        return 'Usuarios';

    }

    public function headings(): array
    {
        return[
            'ID',
            'Nombre',
            'Correo',
            'Fecha de creación',
            'última actualizacion',            

        ];

    }

}
