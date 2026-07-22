@extends('layouts.auth')

@section('title', 'Iniciar Sesión')
@section('contenido')

<!-- Mensajes y Notificaciones -->
@if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible m-2" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible m-2" role="alert">
        <strong><i class="fa-solid fa-triangle-exclamation"></i> Por favor corrige los siguientes errores:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="align-items-center card mt-5 p-4 shadow-sm">
                <div class="text-center m-2">
                    <img src="{{ asset('imagenes/logo_telpri.png') }}" alt="Logo Telpri" class="img-fluid mb-3" style="max-height: 80px;">
                    <h4 class="mb-0">Iniciar Sesión</h4>
                </div>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row m-2">
                        <label for="email">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>                            
                    </div>
                    <div class="row m-2">
                        <label for="password">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    Recordarme
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Iniciar sesión
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="row mt-4 justify-content-center align-items-center text-center">
                <div class="col-6 col-md-3 mb-3">
                    <img src="{{ asset('imagenes/logo_cantv.png') }}" alt="Logo Cantv" class="img-fluid" style="max-height: 60px;">
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <img src="{{ asset('imagenes/logo_uneti.png') }}" alt="Logo Uneti" class="img-fluid" style="max-height: 60px;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
