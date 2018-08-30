@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang("messages.reports")</div>

                     <div class="card-body">
                            <a title="Reporte U_PDF" target="_blank" href="{{route('reportes.usuarios')}}"  class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i>USUARIOS PDF</a>            
                            <a title="Reporte U_EXCEL"  href="{{route('reportes.usuarios.excel')}}"  class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i>USUARIOS EXCEL</a>            
                            <a title="Reporte G_EXCEL"  href="{{route('reportes.generos.excel')}}"  class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i>GENEROS EXCEL</a>            
                            <a title="Reporte P_EXCEL"  href="{{route('reportes.peliculas.excel')}}"  class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i>PELICULAS EXCEL</a>            
                            <a title="Reporte P_EXCEL"  href="{{route('reportes.generos_peliculas.excel')}}"  class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i>GEN_PEL EXCEL</a>            

                            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
