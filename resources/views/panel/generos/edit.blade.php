@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Editar Género <a class="btn btn-primary" href="{{url('generos')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        @include('includes.messages')
                        {!! Form::open(['route' => ['generos.update', $genero->idGenero],'method' => 'PATCH']) !!}
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input required type="text" class="form-control" id="nombre" name="nombre" value="{{$genero->nombre}}">
                                </div>
                            </div>

                            <div class="form-group">
                                    <label for="peliculas">Peliculas <span class="badge badge-info">{{count($pels)}}</span></label>
                                    <div style="height:300px;overflow-y: scroll;">
                                      @foreach ($peliculas as $pel)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{\App\Genero::findPelicula($pels,$pel->idPelicula) ? 'checked' : ''}} value="{{$pel->idPelicula}}" name="idPelicula[]">
                                            <label class="form-check-label">
                                                {{$pel->titulo}}
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
