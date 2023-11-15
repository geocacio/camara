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
        <a href="{{ route('materiais-all') }}" class="link">Materiais</a>
    </li>
    <li class="item">
        <span>{{ $material->type->name }}: {{ $material->id }}/{{ date('Y', strtotime($material->date)) }}</span>
    </li>
</ul>

<h3 class="title text-center">{{ $material->type->name }}: {{ $material->id }}/{{ date('Y', strtotime($material->date)) }}</h3>

@endsection

@section('content')

@include('layouts.header')

<section class="section-material-single adjust-min-height margin-fixed-top">
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

                        @if($material->session)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tramite-tab" data-bs-toggle="tab" data-bs-target="#tramite" type="button" role="tab">
                                <i class="fa-solid fa-suitcase"></i>
                                Sessão
                            </button>
                        </li>
                        @endif

                        @if($material->authors)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="authors-tab" data-bs-toggle="tab" data-bs-target="#authors" type="button" role="tab">
                                <i class="fa-solid fa-copy"></i>
                                Autores e subescritores
                            </button>
                        </li>
                        @endif

                        @if($material->session)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="votes-tab" data-bs-toggle="tab" data-bs-target="#votes" type="button" role="tab">
                                <i class="fa-solid fa-microphone"></i>
                                Votações
                            </button>
                        </li>
                        @endif

                        @if($material->recipients)
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

                        @if($material)
                            <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">

                                <h3 class="name-managers">{{ $material->type->name }}: {{ $material->id }}/{{ date('Y', strtotime($material->date)) }}</h3>

                                <div class="row container-descriptions">
                                    <div class="col-md-6">
                                        <p class="title">Autor</p>
                                        <p class="description">{{ $material->councilor->name}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Data</p>
                                        <p class="description">{{ date('d/m/Y', strtotime($material->date)) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Visualizações</p>
                                        <p class="description">{{ $material->views }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">Resumo</p>
                                        <p class="description">{{ $material->description }}</p>
                                    </div>
                                </div>


                            </div>
                        @endif

                        @if($material->authors)
                            <div class="tab-pane fadeshow" id="authors" role="tabpanel" aria-labelledby="authors-tab">

                                @foreach($material->authors as $author)

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
                                
                                                    @foreach($material->authors as $author)
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

                        @if($material->session)
                        
                            <div class="tab-pane fadeshow" id="votes" role="tabpanel" aria-labelledby="votes-tab">

                                Aqui é a votação da sessão

                            </div>
                        @endif

                        @if($material->recipients)
                        
                            <div class="tab-pane fadeshow" id="destinations" role="tabpanel" aria-labelledby="destinations-tab">

                                Lista de destinatários

                            </div>
                        @endif

                        @if($material->session)
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
                                                    <td>{{ date('d/m/Y', strtotime($material->session->date)) }}</td>
                                                    <td>{{ $material->session->status->name }}</td>
                                                    <td>{{ $material->session->exercicy->name }}</td>
                                                    <td>{{ Str::limit($material->session->description, '50', '...') }}</td>
                                                    <td class="actions">
                                                        <a href="{{ route('sessoes.single', $material->session->id) }}" data-toggle="tooltip" title="Ver mais" class="link-view">
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

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Legislatura'])

@include('layouts.footer')

@endsection