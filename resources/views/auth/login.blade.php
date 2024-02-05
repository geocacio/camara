@extends('layouts.app')

@section('content')
<div class="login-screen @if(isset($login) && $login->style_background == "image") img-back @else solid  @endif">
    <div @if(isset($login) && $login->modal == 0) style="width: 100%; height: 100%;" @else class="container" @endif>
        <div class="row @if(isset($login) && $login->modal == 1) min-height-screen @endif @if(isset($login)) justify-content-{{ $login->card_position }} @else justify-content-center @endif align-items-center" @if(isset($login) && $login->modal == 0) style="height: 100%;" @endif> 
            <div class="col-md-6 justify-content-center  @if(isset($login) && $login->modal == 0) full-form @endif">
                <div class="card card-login @if(isset($login) && $login->style_modal == 'transparency') transparency @endif" @if(isset($login) && $login->modal == 0) style="height: 100%; border-radius: 0; background-color: {{ $login->card_color }};" @elseif(isset($login) && $login->modal == 1) style="background-color: {{ $login->card_color }};" @else  @endif>
                    <div class="card-header">
                        @if (isset($login) && $login->show_logo)
                            <figure>
                                <img src="{{ asset('storage/'.$login->logo) }}">
                            </figure>
                        @else
                            <div class="circle">
                                <figure>
                                    <img src="https://static.vecteezy.com/system/resources/previews/024/983/914/original/simple-user-default-icon-free-png.png">
                                </figure>
                            </div>
                        @endif
                    </div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ ('Email') }}" required autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3  justify-content-center">
    
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ ('Senha') }}" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-8 align-items-inline">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('Lembre-me') }}
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Esqueceu sua senha?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
    
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-8 align-items-inline">
                                    <button  class="button-87" type="submit" role="button">
                                        {{ __('Entrar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .login-screen {
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .transparency {
        background-color: transparent!important;
        backdrop-filter: blur(20px) brightness(90%);
    }

    .solid {
        background-color: {{ isset($login) ? $login->background : '#d9d9d9' }};
    }

    .img-back {
        background-image: url("{{ isset($login) ? asset('storage/'.$login->background) : asset('storage/default-background.jpg') }}");
    }

    .button-87 {
        background-color: {{ isset($login) ? $login->button_color : '#1c3992' }};
        &:hover {
            background-color: {{ isset($login) ? $login->button_hover : '#0d256e' }};
        }
    }

    .full-form {
        width: 35%!important;
    }

    @media screen and (max-width: 992px){
        .full-form {
            width: 100%!important;
        }
    }

    .card-header {
        align-items: center;
        justify-content: center;
        display: flex;
    }

    .circle {
        width: 145px;
        height: 145px;
        background-color: #fff;
        border-radius: 50%;

        align-items: center;
        justify-content: center;
        display: flex;
    }

    .circle figure img {
        max-width: 124px!important;
        max-height: 85px!important;
    }
</style>
