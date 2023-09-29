@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('transparency.show') }}" class="link">Portal da transparência</a>
    </li>
    <li class="item">
        <a href="{{ route('ouvidoria.show') }}" class="link">Ouvidoria</a>
    </li>
    <li class="item">
        <a href="{{ route('sic.show') }}" class="link">e-SIC</a>
    </li>
    <li class="item">
        <span>Login</span>
    </li>
</ul>
<h3 class="title text-center">Login</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.sic.sidebar')

            <div class="col-md-8">
                <div class="card main-card">
                    <h3 class="title">Acesse o sistema</h3>

                    @if (session('feedback-success'))
                    <div class="alert alert-success">
                        {!! session('feedback-success') !!}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ $errors->first() }}</li>
                        </ul>
                    </div>
                    @endif

                    <div class="card-body">
                        <form class="form-default" method="post" action="{{ route('sic.login') }}">
                            @csrf

                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                            </div>
                            
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" name="password" class="form-control" value="{{ old('password') }}" />
                            </div>

                            <div class="form-group links">
                                <a href="{{ route('sic.register') }}" class="link">Não tenho conta</a>
                                <a href="{{ route('sic.register') }}" class="link">Esqueci minha senha</a>
                            </div>

                            <div class="form-footer text-center">
                                <button type="submit" class="btn-submit-default">Entrar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Login eSIC'])

@include('layouts.footer')

@endsection