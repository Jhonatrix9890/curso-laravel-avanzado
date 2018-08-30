@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form id='form-login' method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-sm-4 col-form-label text-md-right">E-mail / Username</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id='btn-login' type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <h5>O inicia sesión con</h5>
                                <a href="{{ route('social.auth',"facebook") }}" class="btn btn-block btn-social btn-facebook">
                                    <span class="fa fa-facebook"></span> Facebook
                                </a>
                                <a href="{{ route('social.auth',"google") }}" class="btn btn-block btn-social btn-google">
                                    <span class="fa fa-google"></span> Google
                                </a>
                                <a href="{{ route('social.auth',"linkedin") }}" class="btn btn-block btn-social btn-linkedin">
                                    <span class="fa fa-linkedin"></span> LinkedIn
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("styles")
    <link href="{{ asset('css/bootstrap-social.css') }}" rel="stylesheet">
@endpush
@push("scripts")
    <script type='text/javascript'>
    $(document).ready(function () {
        $( "form" ).submit(function( event ) {
             var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> Cargando...';
             var btn=$('#btn-login');
             if (btn.html() !== loadingText) {            
                btn.html(loadingText);
                btn.prop('disabled', true);
            }
        });
    });
    </script>
@endpush
