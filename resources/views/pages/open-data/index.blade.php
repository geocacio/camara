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
                                    <a target="_blank" class="json title-btn" href="dados-abertos/licitacoes">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/licitacoes">Excel</a>
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

                    <!-- CONTRATOS E ADITIVOS -->
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">CONTRATOS E ADITIVOS</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/contratos">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/contratos">Excel</a>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Numero</li>
                                    <li>Data Contrato</li>
                                    <li>Objeto</li>
                                    <li>Exercicio</li>
                                    <li>Valor Global</li>
                                    <li>Nome Credor</li>
                                    <li>Tipo</li>
                                </ul> 
                            </div>
                        </div>
                    </div>

                    <!-- DETALHAMENTO DE DIÁRIAS -->
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">DETALHAMENTO DE DIÁRIAS</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/diarias">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/diarias">Excel</a>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Exercicio</li>
                                    <li>Nome Desc</li>
                                    <li>Valor Total</li>
                                    <li>Quant</li>
                                    <li>Valor Unit</li>
                                    <li>Nome</li>
                                    <li>Numero</li>
                                    <li>Data</li>
                                </ul> 
                            </div>
                        </div>
                    </div>

                    <!-- LRF (LEI DE RESPONSABILIDADE FISCAL) -->
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">LRF (LEI DE RESPONSABILIDADE FISCAL)</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/lrf">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/lrf">Excel</a>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>DescTipoArq</li>
                                    <li>Exercicio</li>
                                    <li>Data</li>
                                    <li>Desc Lei</li>
                                </ul> 
                            </div>
                        </div>
                    </div>

                    <!-- VEÍCULOS MUNICIPAIS -->
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">VEÍCULOS MUNICIPAIS</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/veiculos">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/veiculos">Excel</a>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Renavan</li>
                                    <li>DataMod</li>
                                    <li>Descricao</li>
                                    <li>Marca</li>
                                    <li>Placa</li>
                                </ul> 
                            </div>
                        </div>
                    </div>

                    <!-- DECRETOS MUNICIPAIS -->
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">DECRETOS MUNICIPAIS</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/decretos-municipais">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/decretos-municipais">Excel</a>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Numero</li>
                                    <li>Data</li>
                                    <li>Descricao</li>
                                    <li>Exercicio</li>
                                </ul> 
                            </div>
                        </div>
                    </div>

                    <!-- PUBLICAÇÕES -->
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">PUBLICAÇÕES</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/publicacoes">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/publicacoes">Excel</a>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Numero</li>
                                    <li>Data</li>
                                    <li>Descricao</li>
                                    <li>Exercicio</li>
                                </ul> 
                            </div>
                        </div>
                    </div>

                    <!-- PORTARIAS -->
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">PORTARIAS</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/portarias">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/portarias">Excel</a>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Exercicio</li>
                                    <li>Descricao</li>
                                    <li>Data</li>
                                    <li>Numero</li>
                                </ul> 
                            </div>
                        </div>
                    </div>

                    <!-- PESSOAL -->
                    <div class="card-body">
                        <div class="square-data">
                            <div class="header-data">
                                <span class="title-data">PESSOAL</span>
                                <div class="btns">
                                    <a target="_blank" class="json title-btn" href="dados-abertos/pessoal">{} Json</a>
                                    <a class="csv title-btn" href="dados-abertos/csv/pessoal">Excel</a>
                                </div>
                            </div>
                            <div class="body-data">
                                <ul>
                                    <li>Data</li>
                                    <li>Numero</li>
                                    <li>Exercicio</li>
                                    <li>Nome</li>
                                    <li>Desc Cargo</li>
                                    <li>Matricula</li>
                                    <li>Cargo</li>
                                    <li>Vinculo</li>
                                    <li>Carga Horaria</li>
                                    <li>Valor</li>
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