@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Dados abertos</span>
    </li>
</ul>
<h3 class="title text-center">Dados Abertos</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card main-card">

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
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">Licitações</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/licitacoes">Json</a>
                                    <button class="csv title-btn">csv</button>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Número</li>
                                    <li>Data de abertura</li>
                                    <li>Status</li>
                                    <li>Valor</li>
                                    <li>Objeto</li>
                                    <li>Credor</li>
                                    <li>Tipo</li>
                                </ul> 
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">LRF (LEI DE RESPONSABILIDADE FISCAL)</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/lrf">Json</a>
                                    <button class="csv title-btn">csv</button>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Número</li>
                                    <li>Data de abertura</li>
                                    <li>Status</li>
                                    <li>Valor</li>
                                    <li>Objeto</li>
                                    <li>Credor</li>
                                    <li>Tipo</li>
                                </ul> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Manifestação'])

@include('layouts.footer')

@endsection