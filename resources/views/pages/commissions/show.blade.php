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

                        @if($progress && count($progress))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tramite-tab" data-bs-toggle="tab" data-bs-target="#tramite" type="button" role="tab">
                                <i class="fa-solid fa-suitcase"></i>
                                Trâmite
                            </button>
                        </li>
                        @endif

                        @if($materials && count($materials))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="material-tab" data-bs-toggle="tab" data-bs-target="#material" type="button" role="tab">
                                <i class="fa-solid fa-copy"></i>
                                Pautas
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
                                    {{-- <div class="col-md-6">
                                        <p class="title">Autor</p>
                                        <p class="description">{{ $commission->councilor->name}}</p>
                                    </div> --}}
                                    {{-- <div class="col-md-6">
                                        <p class="title">Data</p>
                                        <p class="description">{{ date('d/m/Y', strtotime($commission->date)) }}</p>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <p class="title">Tipo</p>
                                        <p class="description">{{ $commission->types[0]->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Visualizações</p>
                                        <p class="description">{{ $commission->views }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">Resumo</p>
                                        <p class="description">{{ $commission->description }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">Mais informações</p>
                                        <p class="description">{{ $commission->more_info }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($materials && count($materials))
                            <div class="tab-pane fadeshow" id="material" role="tabpanel" aria-labelledby="material-tab">

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Matéria</th>
                                                    <th>Ementa</th>
                                                    <th>Data</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            
                                                @foreach($materials as $material)
                                                <tr>
                                                    <td>{{ $material->type->name }}: {{ $material->id }}/{{ date('Y', strtotime($material->date)) }}</td>
                                                    <td>{{ $material->description }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($material->date)) }}</td>
                                                    <td class="actions">
                                                        <a href="{{ route('materiais.single', $material->slug) }}" data-toggle="tooltip" title="Ver mais" class="link-view">
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

                        @if($progress && count($progress))
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
                                                    <th>Observação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($progress as $item)
                                                <tr>
                                                    <td>{{ date('d/m/Y', strtotime($item->proceeding->sessions->date)) }}</td>
                                                    <td>{{ $item->proceeding->sessions->id }}/{{ date('Y', strtotime($item->proceeding->sessions->date)) }}</td>
                                                    <td>{{ $item->proceeding->category->name }}</td>
                                                    <td>{{ $item->phase }}</td>
                                                    <td>{{ $item->observation }}</td>
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

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Comissão'])

@include('layouts.footer')

@endsection