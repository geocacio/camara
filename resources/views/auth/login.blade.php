@extends('layouts.app')

@section('content')
<div @if($login->modal == 0) style="width: 100%; height: 100%;" @else class="container" @endif>
    <div class="row @if($login->modal == 1) min-height-screen @endif justify-content-{{ $login->card_position }} align-items-center" @if($login->modal == 0) style="height: 100%;" @endif> 
        <div class="col-md-6 justify-content-center  @if($login->modal == 0) full-form @endif">
            <div class="card card-login" @if($login->modal == 0) style="height: 100%; border-radius: 0; background-color: {{ $login->card_color }};" @endif>
                <div class="card-header">
                    <figure>
                        <img src="https://trello.com/1/cards/6586d467e3a3d92e9cf8e02b/attachments/6587628bb56cbf2ee5778adf/previews/6587628db56cbf2ee5778b27/download/LH_Service_cart%C3%A3o.png">
                    </figure>
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
@endsection

<style>
    #app{
        background-repeat: no-repeat;
        overflow: hidden;
        background-image: url("{{ asset('storage/'.$login->background) }}");
    }

    .button-87 {
        background-color: {{ $login->button_color }};
        &:hover {
            background-color: {{ $login->button_hover }};
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

</style>