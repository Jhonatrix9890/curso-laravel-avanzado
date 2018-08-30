@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Información de Usuario <a class="btn btn-primary" href="{{url('usuarios')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><b>Nombre:</b> {{$usuario->name}}</li>
                            <li class="list-group-item"><b>E-mail:</b> {{$usuario->email}} </li>
                            <li class="list-group-item"><b>Fecha de creación:</b> {{$usuario->created_at}}</li>
                            <li class="list-group-item"><b>Ultima Actualizacion</b> {{$usuario->updated_at}}</li>
                        </ul>
                        <h4>Roles</h4>
                        @if (count($usuario->roles) > 0)
                            <ul class="list-group">
                                @foreach ($usuario->roles as $rol)
                                    <li class="list-group-item">{{$rol->display_name}}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>El usuario no tiene roles registrados</strong>
                            </div>
                        @endif
           
                       
                    </div>
                </div>
            </div>
  
        </div>
    </div>
@endsection
