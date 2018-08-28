@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Películas  <a class="btn btn-primary" href="{{url('peliculas/create')}}" title="Nueva película" role="button">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </a></div>
                <div class="card-body">
                    @include('includes.messages')
                    @include('panel.peliculas.delete')
                    @include('panel.peliculas.trash')
                    @include('panel.peliculas.restore')

                    <a class="btn btn-link {{strpos(Request::fullUrl(), 'peliculas?display=all') ? 'disabled' : ''}}" href="{{URL::action('PeliculaController@index',['display'=>'all'])}}">Todas</a> | 
                     <a class="btn btn-link" href="{{url('peliculas')}}">Activos</a> | 
                    <a class="btn btn-link {{strpos(Request::fullUrl(), 'peliculas?display=trash') ? 'disabled' : ''}}" href="{{URL::action('PeliculaController@index',['display'=>'trash'])}}" href="{{URL::action('PeliculaController@index',['display'=>'trash'])}}">Papelera</a>


                <div class="table-responsive">
                   
                    {{$peliculas->appends(Request::capture()->except('page'))->links()}}
                   
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Título</th>
                        <th scope="col">Año</th>
                        <th scope="col">Duración</th>
                        <th scope="col">Géneros</th>                   
                        
                        <th scope="col">Actores</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Usuario</th>
                   
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peliculas as $pel)
                            <tr>
                                <th scope="row">{{$pel->titulo}}</th>
                                <td>{{$pel->anio}}</td>
                                <td>{{$pel->duracion}}</td>
                                <td>
                                    <span class="badge badge-pill badge-{{$pel->generos_count == 0 ? 'danger' : 'info' }}">{{$pel->generos_count}}</span>
                                </td>
                               
                                <td>
                              
                                <span class="badge badge-pill badge-{{$pel->actores_count == 0 ? 'danger' : 'info' }}">{{$pel->actores_count}}</span> 
                              
                                </td>
                                <td>
                                    @if($pel->imagen == null)
                                        -
                                    @else
                                        <img src="{{\Storage::url($pel->imagen)}}" style="max-width:75px;">
                                    @endif
                                </td>
                                <td>
                                <td>
                                    {{$pel->usuario->name}}
                                </td>

                                @if ($pel->trashed())                              
                                     <a title="Restaurar" data-toggle="modal" data-target="#modalRestore" 
                                        data-name="{{$pel->titulo}}" href="#"
                                        data-action="{{route('peliculas.restore',$pel->idPelicula)}}"
                                        class="btn btn-success btn-xs"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                        <a title="Borrar permanentemente" data-toggle="modal" data-target="#modalDelete" 
                                        data-name="{{$pel->titulo}}" href="#"
                                        data-action="{{route('peliculas.destroy',$pel->idPelicula)}}"
                                        class="btn btn-warning btn-xs"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>

                                @else
                                    <a title="Ver" href="{{route('peliculas.show',$pel->idPelicula)}}" class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i></a>
                                    <a title="Editar" href="{{route('peliculas.edit',$pel->idPelicula)}}" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a title="Enviar a la papelera" data-toggle="modal" data-target="#modalTrash" 
                                    data-name="{{$pel->titulo}}" href="#"
                                    data-action="{{route('peliculas.trash',$pel->idPelicula)}}"
                                    class="btn btn-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                    {{$peliculas->appends(Request::capture()->except('page'))->links()}}
                </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@prepend('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#modalTrash').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var modal = $(this);
            modal.find(".modal-content #txtTrash").html("¿Está seguro de eliminar la Película <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
        $('#modalDelete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var modal = $(this);
            modal.find(".modal-content #txtDelete").html("¿Está seguro de eliminar permanentemente la Película <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
        $('#modalRestore').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var modal = $(this);
            modal.find(".modal-content #txtRestore").html("¿Está seguro de restaurar la Película <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
    });
</script>
@endprepend
