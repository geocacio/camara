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
        <a href="{{ route('sic.show') }}" class="link">e-SIC</a>
    </li>
    <li class="item">
        <span>Painel</span>
    </li>
</ul>
<h3 class="title text-center">eSic - Painel de controle</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.sic.sidebar')

            <div class="col-md-8">
                <div class="card main-card">
                    <h3 class="title">Bem vindo Odilon</h3>

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
                        <div class="row mb-30">
                            <div class="col-md-6">
                                <a href="{{ route('solicitacoes.create') }}" class="box-first-layout primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="title">Registrar solicitação.</span>
                                    <span class="text">Clique aqui para registrar seu solicitação.</span>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('solicitacoes.index') }}" class="box-first-layout secondary">
                                    <i class="fa-solid fa-table-list"></i>
                                    <span class="title">Minhas solicitações.</span>
                                    <span class="text">Clique aqui para ver seus solicitação.</span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('sic.profile') }}" class="box-first-layout third">
                                    <i class="fa-solid fa-user"></i>
                                    <span class="title">Dados cadastrados.</span>
                                    <span class="text">Visualizar suas informações cadastradas.</span>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="box-first-layout fourth" onclick="event.preventDefault();
                                    document.getElementById('form-sic-logout').submit();">
                                    <i class="fa-solid fa-power-off"></i>
                                    <span class="title">Sair.</span>
                                    <span class="text">Clique aqui para sair do painel.</span>
                                </a>
                                <form id="form-sic-logout" method="POST" action="{{ route('sic.logout') }}" style="display: none;">@csrf</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Painel eSIC'])

@include('layouts.footer')

@endsection