@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('CREAR CUENTA') }}</div>

                <div class="card-body">
                        
                        @if(session('error'))
                            <div class="alert alert-success" role="alert">
                        {{$session('error')}}
                        </div>
                        @endif

                    <form method="POST" action="{{ route('register') }}" class="prevent-double-submit">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Empresa') }}</label>

                            <div class="col-md-6">
                                <input class="form-control" id="company" type="text"  name="company" required>

                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="cuit" class="col-md-4 col-form-label text-md-right">{{ __('CUIT') }}</label>

                            <div class="col-md-6">
                                <input class="form-control" id="cuit" type="number"  name="cuit" maxlength="11" placeholder="Ingrese el CUIT sin puntos ni guiones" required>

                            </div>
                        </div>


                         <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono') }}</label>

                            <div class="col-md-6">
                                <input class="form-control" id="phone" type="number"  name="phone" placeholder="Ingrese un teléfono de contacto" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-info prevent-button">
                                    <i class="spinner fa fa-spinner fa-spin" hidden></i>
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/submit.js"></script>
@endsection
