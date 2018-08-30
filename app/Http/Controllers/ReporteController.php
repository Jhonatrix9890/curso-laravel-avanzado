<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Auth;
use App\User;
use App\Exports\UserExport;
use App\Exports\GeneroExport;
use App\Exports\PeliculaExport;
use App\Exports\Genero2Export;
use Excel;

class ReporteController extends Controller
{
    public function reporteUsuarios(){

        $usuarios = User::with('roles')->orderBy('name')->get();
        $reporte=PDF::loadView('reportes.usuarios', compact('usuarios'));
        $reporte=$reporte->stream('Reporte Usuarios.pdf');
        return $reporte;

    }

    public function index(){


        return view('reportes.index');
    }

    public function reporteUsuariosExcel(){

       return Excel::download(new UserExport, 'usuarios.xlsx');
    
     
    }
    public function reporteGeneroExcel(){

        return Excel::download(new GeneroExport, 'generos.xlsx');
     
      
     }
     public function reportePeliculasExcel(){

        return Excel::download(new PeliculaExport, 'Peliculas.xlsx');
     
      
     }
     public function reporteGenerosPorPeliculasExcel(){

        return Excel::download(new Genero2Export, 'GenerosPeliculas.xlsx');
     
      
     }


}
