@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Editar actor <a class="btn btn-primary" href="{{url('actores')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        @include('includes.messages')
                        {!! Form::open(['route' => ['actores.update', $actor->idActor],'method' => 'PATCH']) !!}
                            <div class="form-group row">
                                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                                <div class="col-sm-10">
                                    <input required type="text" class="form-control" id="nombres" name="nombres" value="{{$actor->nombres}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                                <div class="col-sm-4">
                                <input required type="text" class="form-control" id="apellidos" name="apellidos" value="{{$actor->apellidos}}">
                                  </div>
                                
                            </div>
                            <div class="form-group">
                                    <label for="peliculas">Pelicula <span class="badge badge-info">{{count($gens)}}</span></label>
                                    <div style="height:300px;overflow-y: scroll;">
                                      @foreach ($peliculas as $gen)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{\App\Actor::findPelicula($gens,$gen->idPelicula) ? 'checked' : ''}} value="{{$gen->idPelicula}}" name="idPelicula[]">
                                            <label class="form-check-label">
                                                {{$gen->titulo}}
                                            </label>
                                          </div>
                                      @endforeach
                                    </div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-sm-10">
                                      <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
