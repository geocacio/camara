@extends('layouts.app')

@section('content')
<div id="login-screen" class="login-screen">
    <div id="loading-spinner" class="loading-spinner">
        <div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>

    <div style="display: none" id="container-lg">
        <div id="screen-height" class="row">
            <div id="form-type" class="col-md-6 justify-content-center">
                <div id="cardLogin" class="card card-login">
                    <div class="card-header">
                        <figure id="sistemLogo" class="displayNone">
                            <img id="logoImage" src="">
                        </figure>

                        <div id="showIcon" class="circle displayNone">
                            <figure>
                                <img src="https://static.vecteezy.com/system/resources/previews/024/983/914/original/simple-user-default-icon-free-png.png">
                            </figure>
                        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var loadingSpinner = document.getElementById('loading-spinner');
    var hidePage = document.getElementById('container-lg');

    function showLoadingSpinner() {
        loadingSpinner.style.display = 'block';
        hidePage.style.display = 'none';
    }
    
    function hideLoadingSpinner() {
        loadingSpinner.style.display = 'none';
        hidePage.style.display = 'block';
    }

    function handleResponse(xhr) {
        if (xhr.readyState == 4) {
            hideLoadingSpinner();
            if (xhr.status == 200) {
                var responseData = JSON.parse(xhr.responseText);
                console.log(responseData);

                var loginData = responseData;
                defineStyle(loginData);
                console.log(loginData);
            }
        }
    }

    showLoadingSpinner();

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/login/custom', true);

    xhr.onload = function () {
        handleResponse(xhr);
    };

    xhr.send();

    function defineStyle(loginData) {
        var loginScreen = document.getElementById('login-screen');
        var containerLogin = document.getElementById('container-lg');
        var screenHeight = document.getElementById('screen-height');
        var formType = document.getElementById('form-type');
        var cardLogin = document.getElementById('cardLogin');

        var btn = loginScreen.querySelector('.button-87');
        if (btn) {
            btn.style.backgroundColor = loginData.button_color;

            btn.addEventListener('mouseover', function() {
                btn.style.backgroundColor = loginData.button_hover;
            });

            btn.addEventListener('mouseout', function() {
                btn.style.backgroundColor = loginData.button_color;
            });
        }


        if (loginData.style_background === "image") {
            loginScreen.classList.add('img-back');
            var currentBackground = 'storage/' + loginData.background;
            loginScreen.style.backgroundImage = 'url(' + currentBackground + ')';
        } else {
            loginScreen.classList.add('solid');
            loginScreen.style.backgroundColor = loginData.background;
        }

        var header = loginScreen.querySelector('.card-header');

        var showLogo = document.getElementById('sistemLogo');
        var showIcon = document.getElementById('showIcon');

        if (loginData.show_logo == 1) {
            showLogo.classList.remove('displayNone');
            var currentLogo = 'storage/' + loginData.logo;
            var imagem = document.getElementById('logoImage');
            imagem.src = currentLogo;
        } else {
            showIcon.classList.remove('displayNone');
        }

        if (loginData.modal === 0) {
            containerLogin.style.width = "100%";
            containerLogin.style.height = "100%";
        }

        if (loginData.modal === 1) {
            screenHeight.classList.add('min-height-screen');
        }

        if (loginData.card_position) {
            screenHeight.classList.add('justify-content-' + loginData.card_position);
        } else {
            screenHeight.classList.add('justify-content-center');
        }

        if (loginData.modal === 0) {
            screenHeight.style.height = '100%';
        }

        if (loginData.modal == 0) {
            cardLogin.style.height = "100%";
            cardLogin.style.borderRadius = 0;
            formType.classList.add('full-form');
        } else {
            formType.classList.remove('col-md-6');
            cardLogin.style.width = "100%";
        }
        
        if(loginData.style_modal == 'transparency'){
            cardLogin.classList.add('transparency');
        }else {
            cardLogin.style.backgroundColor = loginData.card_color;
        }
    }
});

</script>

<style>
    #loading-spinner {
        display: none;
        background-color: #1f296d;
        border-radius: 8px;
        padding: 10;

        -webkit-box-shadow: 0px 0px 12px -1px #000000; 
        box-shadow: 0px 0px 12px -1px #000000;
    }

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

    .displayNone {
        display: none!important;
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

    .lds-grid {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }
    .lds-grid div {
        position: absolute;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #fff;
        animation: lds-grid 1.2s linear infinite;
    }
    .lds-grid div:nth-child(1) {
        top: 8px;
        left: 8px;
        animation-delay: 0s;
    }
    .lds-grid div:nth-child(2) {
        top: 8px;
        left: 32px;
        animation-delay: -0.4s;
    }
    .lds-grid div:nth-child(3) {
        top: 8px;
        left: 56px;
        animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(4) {
        top: 32px;
        left: 8px;
        animation-delay: -0.4s;
    }
    .lds-grid div:nth-child(5) {
        top: 32px;
        left: 32px;
        animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(6) {
        top: 32px;
        left: 56px;
        animation-delay: -1.2s;
    }
    .lds-grid div:nth-child(7) {
        top: 56px;
        left: 8px;
        animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(8) {
        top: 56px;
        left: 32px;
        animation-delay: -1.2s;
    }
    .lds-grid div:nth-child(9) {
        top: 56px;
        left: 56px;
        animation-delay: -1.6s;
    }
    @keyframes lds-grid {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
</style>
