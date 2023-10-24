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
        <a href="{{ route('comissoes-all') }}" class="link">Comissões</a>
    </li>
    <li class="item">
        <span>{{ Str::limit($commission->description, '30', '...') }}</span>
    </li>
</ul>

<h3 class="title text-center">{{ Str::limit($commission->description, '30', '...') }}</h3>

@endsection

@section('content')

@include('layouts.header')

<section class="section-commission-single adjust-min-height margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card main-card">
                    <ul class="nav nav-tabs nav-tab-page" id="myTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="index-tab" data-bs-toggle="tab" data-bs-target="#index" type="button" role="tab">
                                <i class="fa-solid fa-user-tie"></i>
                                Sobre
                            </button>
                        </li>

                        @if($commission->session)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tramite-tab" data-bs-toggle="tab" data-bs-target="#tramite" type="button" role="tab">
                                <i class="fa-solid fa-suitcase"></i>
                                Sessão
                            </button>
                        </li>
                        @endif

                        @if($commission->authors)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="authors-tab" data-bs-toggle="tab" data-bs-target="#authors" type="button" role="tab">
                                <i class="fa-solid fa-copy"></i>
                                Autores e subescritores
                            </button>
                        </li>
                        @endif

                        @if($commission->session)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="votes-tab" data-bs-toggle="tab" data-bs-target="#votes" type="button" role="tab">
                                <i class="fa-solid fa-microphone"></i>
                                Votações
                            </button>
                        </li>
                        @endif

                        @if($commission->recipients)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="destinations-tab" data-bs-toggle="tab" data-bs-target="#destinations" type="button" role="tab">
                                <i class="fa-solid fa-users"></i>
                                Destinatários
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-8">

                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">

                        @if($commission)
                            <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">

                                <h3 class="name-managers">{{ $commission->description }}</h3>

                                <div class="row container-descriptions">
                                    <div class="col-md-6">
                                        <p class="title">Autor</p>
                                        {{-- <p class="description">{{ $commission->councilor->name}}</p> --}}
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Data</p>
                                        <p class="description">{{ date('d/m/Y', strtotime($commission->date)) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Visualizações</p>
                                        <p class="description">{{ $commission->views }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">Resumo</p>
                                        <p class="description">{{ $commission->description }}</p>
                                    </div>
                                </div>


                            </div>
                        @endif

                        @if($commission->authors)
                            <div class="tab-pane fadeshow" id="authors" role="tabpanel" aria-labelledby="authors-tab">

                                @foreach($commission->authors as $author)

                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-data-default">
                                                <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>Cargo</th>
                                                        <th>Partido</th>
                                                        <th>Autoria</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                
                                                    @foreach($commission->authors as $author)
                                                    <tr>
                                                        <td>{{ $author->name }}</td>
                                                        <td>{{ $author->position }}</td>
                                                        <td>{{ $author->party }}</td>
                                                        <td>{{ $author->authorship }}</td>
                                                    </tr>
                                                    @endforeach
                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        @endif

                        @if($commission->session)
                        
                            <div class="tab-pane fadeshow" id="votes" role="tabpanel" aria-labelledby="votes-tab">

                                Aqui é a votação da sessão

                            </div>
                        @endif

                        @if($commission->recipients)
                        
                            <div class="tab-pane fadeshow" id="destinations" role="tabpanel" aria-labelledby="destinations-tab">

                                Lista de destinatários

                            </div>
                        @endif

                        @if($commission->session)
                            <div class="tab-pane fadeshow" id="tramite" role="tabpanel" aria-labelledby="tramite-tab">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Status</th>
                                                    <th>Exercício</th>
                                                    <th>Descrição</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ date('d/m/Y', strtotime($commission->session->date)) }}</td>
                                                    <td>{{ $commission->session->status->name }}</td>
                                                    <td>{{ $commission->session->exercicy->name }}</td>
                                                    <td>{{ Str::limit($commission->session->description, '50', '...') }}</td>
                                                    <td class="actions">
                                                        <a href="{{ route('sessoes.single', $commission->session->id) }}" data-toggle="tooltip" title="Ver mais" class="link-view">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Comissão'])

@include('layouts.footer')

@endsection