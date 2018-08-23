@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Actores  <a class="btn btn-primary" href="{{url('actores/create')}}" title="Nuevo actor" role="button">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </a></div>
                <div class="card-body">
                    @include('includes.messages')
                    @include('panel.actores.delete')
                    @include('panel.actores.trash')
                    @include('panel.actores.restore')
                    <a class="btn btn-link {{strpos(Request::fullUrl(), 'actores?display=all') ? 'disabled' : ''}}" href="{{URL::action('ActorController@index',['display'=>'all'])}}">Todos</a> | 
                    <a class="btn btn-link" href="{{url('actores')}}">Activos</a> | 
                    <a class="btn btn-link {{strpos(Request::fullUrl(), 'actores?display=trash') ? 'disabled' : ''}}" href="{{URL::action('ActorController@index',['display'=>'trash'])}}" href="{{URL::action('ActorController@index',['display'=>'trash'])}}">Papelera</a>

                <div class="table-responsive">
                {{$actores->appends(Request::capture()->except('page'))->links()}}
                    <!-- {{$actores->links()}} -->
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th> 
                        <th scope="col">Peliculas</th>
                        <th scope="col">Imagen</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actores as $act)
                            <tr>
                                <th scope="row">{{$act->nombres}}</th>
                                <th scope="row">{{$act->apellidos}}</th>
                                <td>
                                    <span class="badge badge-pill badge-{{$act->peliculas_count == 0 ? 'danger' : 'info' }}">{{$act->peliculas_count}}</span>
                                </td>
                                <td>
                                    @if($act->imagen == null)
                                        -
                                    @else
                                        <img src="{{\Storage::url($act->imagen)}}" style="max-width:75px;">
                                    @endif
                                </td>
                                <td>
                                   
                                    @if ($act->trashed())
                                        <a title="Restaurar" data-toggle="modal" data-target="#modalRestore" 
                                        data-name="{{$act->nombres}}" href="#"
                                        data-action="{{route('actores.restore',$act->idActor)}}"
                                        class="btn btn-success btn-xs"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                        <a title="Borrar permanentemente" data-toggle="modal" data-target="#modalDelete" 
                                        data-name="{{$act->nombres}}" href="#"
                                        data-action="{{route('actores.destroy',$act->idActor)}}"
                                        class="btn btn-warning btn-xs"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
                                  
                                    @else
                                    
                                        <a title="Ver" href="{{route('actores.show',$act->idActor)}}" class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i></a>
                                        <a title="Editar" href="{{route('actores.edit',$act->idActor)}}" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a title="Enviar a papelera" data-toggle="modal" data-target="#modalTrash" 
                                        data-name="{{$act->nombres}}" href="#"
                                        data-action="{{route('actores.trash',$act->idActor)}}"
                                        class="btn btn-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    @endif
                                
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                    {{$actores->links()}}
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
            modal.find(".modal-content #txtTrash").html("¿Está seguro de eliminar el actor <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
        $('#modalDelete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var modal = $(this);
            modal.find(".modal-content #txtDelete").html("¿Está seguro de eliminar permanentemente el actor <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
        $('#modalRestore').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var modal = $(this);
            modal.find(".modal-content #txtRestore").html("¿Está seguro de restaurar el actor <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
    });
</script>
@endprepend
