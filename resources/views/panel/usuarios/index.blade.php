@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Usuarios  
                    
                    {{--  <a class="btn btn-primary" href="{{url('usuarios/create')}}" title="Nuevo Usuario" role="button">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>  --}}

                    <a title="Nuevo Usuario" data-toggle="modal" data-target="#modalCreate" 
                    href="#"                   
                    class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>

                </div>
                <div class="card-body">
                    @include('includes.messages')
                    @include('panel.usuarios.create')
                    @include('panel.usuarios.edit')
 

                    <a class="btn btn-link {{strpos(Request::fullUrl(), 'peliculas?display=all') ? 'disabled' : ''}}" href="{{URL::action('PeliculaController@index',['display'=>'all'])}}">Todas</a> | 
                   <a class="btn btn-link" href="{{url('peliculas')}}">Activos</a> | 
                  <a class="btn btn-link {{strpos(Request::fullUrl(), 'peliculas?display=trash') ? 'disabled' : ''}}" href="{{URL::action('PeliculaController@index',['display'=>'trash'])}}" href="{{URL::action('PeliculaController@index',['display'=>'trash'])}}">Papelera</a>


                <div class="table-responsive">
                   
                    {{$usuarios->appends(Request::capture()->except('page'))->links()}}
                   
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Fecha de creacion</th>
                        <th scope="col">Ultima actualizacion</th>  
                        <th scope="col">Rol</th> 
                        <th scope="col"></th>                    
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $us)
                            <tr>
                                <th scope="row">{{$us->name}}</th>
                                <td>{{$us->email}}</td>
                                <td>{{$us->created_at}}</td>
                                <td>{{$us->updated_at}}</td>
                                <td>
                                    @foreach ($us->roles as $r)
                                    {{$r->display_name}}
                                    @endforeach
                                </td>
                                <td>
                                        <a title="Ver" href="{{route('usuarios.show',$us->id)}}" class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i></a>            
                                        <a title="Cambiar rol" data-toggle="modal" data-target="#modalEdit" 
                                        data-name="{{$us->name}}" data-email="{{$us->email}}" 
                                        data-rol="{{count($us->roles)== 0 ?: $us->roles[0]->id}}" 
                                        href="#" data-action="{{route('usuarios.update',$us->id)}}"
                                        class="btn btn-success btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    </td>  
                                    </tr>
                        @endforeach
                    </tbody>
                    </table>
                    {{$usuarios->appends(Request::capture()->except('page'))->links()}}
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
        $('#modalEdit').on('show.bs.modal', function (event) {
            console.log('modalEdit');
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var email = button.data('email');
            var idRol = button.data('rol');
            var modal = $(this);
            modal.find(".modal-content #name").val(name);
            modal.find(".modal-content #email").val(email);
            modal.find(".modal-content #idRol").val(idRol);
            modal.find(".modal-content form").attr('action', action);
        });
    });
</script>
@endprepend
