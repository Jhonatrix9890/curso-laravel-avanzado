@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@lang('messages.settings')</div>
                <div class="card-body">
                    @include('includes.messages')
                    <ul class="list-group">
                        <li class="list-group-item"><b>Nick Name:</b> {{$usuario->name}}</li>
                        <li class="list-group-item"><b>E-mail:</b> {{$usuario->email}}</li>
                        <li class="list-group-item"><b>Fecha Creación:</b> {{$usuario->created_at}}</li>
                        <li class="list-group-item"><b>Última Actualización:</b> {{$usuario->updated_at}}</li>
                        <li class="list-group-item"><b>Rol:</b> {{count($usuario->roles)== 0 ?: $usuario->roles[0]->display_name}}</li>
                    </ul>
                    <div id="accordion">
                            <div class="card">
                              <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Cambiar contraseña
                                  </button>
                                </h5>
                              </div>
                          
                              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                        {!! Form::open(['url' => LaravelLocalization::getCurrentLocale().'/change_password']) !!}
                                            <div class="form-group row">
                                                <label for="password_now" class="col-sm-2 col-form-label">Contraseña actual</label>
                                                <div class="col-sm-10">
                                                    <input required type="password" class="form-control" id="password_now" name="password_now" minlength="8" maxlength="25">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Nueva contraseña</label>
                                                <div class="col-sm-10">
                                                    <input required type="password" class="form-control" id="password" name="password" minlength="8" maxlength="25">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password_confirmed" class="col-sm-2 col-form-label">Confirmar contraseña</label>
                                                    <div class="col-sm-10">
                                                    <input required type="password" class="form-control" id="password_confirmed" name="password_confirmation" minlength="8" maxlength="25">
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
            </div>
        </div>
    </div>
</div>
@endsection
