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

                        @if($material->progress)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tramite-tab" data-bs-toggle="tab" data-bs-target="#tramite" type="button" role="tab">
                                <i class="fa-solid fa-suitcase"></i>
                                Trâmite
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
                                                <!-- <th>Cargo</th> -->
                                                <th>Partido</th>
                                                <th>Autoria</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $material->councilor->name }}</td>
                                                <td>{{ $material->councilor->partyAffiliation->acronym }}</td>
                                                <td>Autor</td>
                                            </tr>

                                            @foreach($material->authors as $author)
                                            <tr>
                                                <td>{{ $author->councilor->name }}</td>
                                                <!-- <td>{{ $author->position }}</td> -->
                                                <td>{{ $author->councilor->partyAffiliation->acronym }}</td>
                                                <td>Subescritor</td>
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

                            @foreach($material->authors as $author)

                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-data-default">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <!-- <th>Cargo</th> -->
                                                <th>Cargo</th>
                                                <th>Orgão</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($material->recipients as $recipient)
                                            <tr>
                                                <td>{{ $recipient->name }}</td>
                                                <td>{{ $recipient->position }}</td>
                                                <td>{{ $recipient->organization }}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @endforeach

                        </div>
                        @endif

                        @if($material->progress && $material->progress->count() > 0)
                        <div class="tab-pane fadeshow" id="tramite" role="tabpanel" aria-labelledby="tramite-tab">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-data-default">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Sessão</th>
                                                <th>Expediente</th>
                                                <th>Fase</th>
                                                <th>Situação</th>
                                                <th>Observação</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($material->progress as $progress)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($progress->created_at)) }}</td>
                                                <td>{{ $progress->proceeding->sessions->slug }}: {{ $progress->proceeding->sessions->id }}/{{ date('Y', strtotime($progress->proceeding->sessions->date)) }}</td>
                                                <td>{{ $progress->proceeding->category->name }}</td>
                                                <td>{{ $progress->phase }}</td>
                                                <td>estudar...</td>
                                                <td>{{ $progress->description }}</td>
                                                <td class="actions">
                                                    <a href="{{ route('sessoes.single', $progress->proceeding->sessions->slug) }}" data-toggle="tooltip" title="Ver mais" class="link-view">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
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

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Material'])

@include('layouts.footer')

@endsection