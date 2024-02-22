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
        <a href="{{ route('bidding.page') }}" class="link">Licitações</a>
    </li>
    <li class="item">
        <span>{{ Str::limit($bidding->number, '30', '...') }}</span>
    </li>
</ul>

<h4 class="title-biddings text-center">
    @if(isset($categorieModalidade))
        {{ $categorieModalidade->name }}:
    @endif

    @if(isset($bidding) && !empty($bidding->number))
        {{ Str::limit($bidding->number, '30', '...') }} - EXERCÍCIO:
    @endif

    @if(isset($exercice))
        {{ $exercice->name }} -
    @endif

    @if(isset($bidding))
        {{ $bidding->status }}
    @endif
</h4>

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
                                <i class="fa-regular fa-file-lines"></i>
                                informações principais
                            </button>
                        </li>

                        @if($bidding->publicationForms && count($bidding->publicationForms))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="public-form-tab" data-bs-toggle="tab" data-bs-target="#public-form" type="button" role="tab">
                                <i class="fa-solid fa-calendar-days"></i>
                                Formas de publicação
                            </button>
                        </li>
                        @endif

                        @if($bidding->responsibilities && count($bidding->responsibilities))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="response-tab" data-bs-toggle="tab" data-bs-target="#response" type="button" role="tab">
                                <i class="fa-solid fa-address-card"></i>
                                Responsáveis
                            </button>
                        </li>
                        @endif

                        @if($bidding->company)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="participantes-tab" data-bs-toggle="tab" data-bs-target="#participantes" type="button" role="tab">
                                    <i class="fa-solid fa-users-gear"></i>
                                    Participantes
                                </button>
                            </li>
                        @endif

                        @if($bidding->company)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contracts-tab" data-bs-toggle="tab" data-bs-target="#contracts" type="button" role="tab">
                                    <i class="fa-solid fa-file-signature"></i>
                                    Contratos
                                </button>
                            </li>
                        @endif

                        {{-- @if($materials && count($materials))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="material-tab" data-bs-toggle="tab" data-bs-target="#material" type="button" role="tab">
                                <i class="fa-solid fa-copy"></i>
                                Participantes
                            </button>
                        </li>
                        @endif --}}

                        @if($bidding->progress && count($bidding->progress))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="membros-tab" data-bs-toggle="tab" data-bs-target="#membros" type="button" role="tab">
                                <i class="fa-solid fa-bars-progress"></i>
                                Andamentos
                            </button>
                        </li>
                        @endif

                        @if($filesBidding && count($filesBidding) > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">
                                <i class="fa-regular fa-file"></i>
                                Arquivos disponíveis
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-8">

                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">

                        @if($bidding)
                            <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">

                                <h3 class="name-managers">{{ $bidding->description }}</h3>
                                <div class="row container-descriptions">
                                    <div class="col-md-6">
                                        <p class="title">Licitação</p>
                                        <p class="description">{{ $bidding->number }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">Data de início</p>
                                        <p class="description">{{ date('d/m/Y', strtotime($bidding->opening_date)) }}</p>
                                    </div>
                                    

                                    <div class="col-md-12">
                                        <p class="title">Status</p>
                                        <p class="description">{{ $bidding->status }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">Valor</p>
                                        <p class="description">R$ {{ number_format($bidding->estimated_value, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($bidding->publicationForms && count($bidding->publicationForms))
                            <div class="tab-pane fadeshow" id="public-form" role="tabpanel" aria-labelledby="public-form-tab">

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Descrição</th>
                                                    <th>Publicação</th>
                                                    {{-- <th>Ação</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                            
                                                @foreach($bidding->publicationForms as $publicationForm)
                                                <tr>
                                                    <td>{{ $publicationForm->type }}</td>
                                                    <td>{{ $publicationForm->description }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($publicationForm->date)) }}</td>
                                                    {{-- <td class="actions">
                                                        <a href="{{ route('materiais.single', $publicationForm->slug) }}" data-toggle="tooltip" title="Ver mais" class="link-view">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                    </td> --}}
                                                </tr>
                                                @endforeach
                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        @endif

                        @if($bidding->company)
                            <div class="tab-pane fadeshow" id="participantes" role="tabpanel" aria-labelledby="participantes-tab">

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Participante</th>
                                                    <th>Resultado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $bidding->company->name }}</td>
                                                    <td>Vencedor</td>
                                                </tr>             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        @endif

                        @if($bidding->company)
                            <div class="tab-pane fadeshow" id="contracts" role="tabpanel" aria-labelledby="contracts-tab">

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Número</th>
                                                    <th>Credor/Vencedor</th>
                                                    <th>Valor</th>
                                                    <th>Periodo</th>
                                                    <th>Mais</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bidding->company->contracts as $contract)
                                                    <tr>
                                                        <td>{{ $contract->number }}</td>
                                                        <td>{{ $bidding->company->name }}</td>
                                                        <td>R$ {{ number_format($contract->total_value, 2, ',', '.') }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($contract->start_date)) . ' - ' . date('d/m/Y', strtotime($contract->end_date)) }}</td>
                                                        <td style="cursor: pointer"> 
                                                            <a href="{{ asset('storage/'.$contract->files->file->url) }}" target="_blank">
                                                                <i class="fa-regular fa-eye"></i>
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

                        @if($bidding->responsibilities && count($bidding->responsibilities))
                            <div class="tab-pane fadeshow" id="response" role="tabpanel" aria-labelledby="response-tab">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Responsabilidade</th>
                                                    <th>A gente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bidding->responsibilities as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->pivot->employee->name }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- @if($members && count($members))
                            <div class="tab-pane fadeshow" id="membros" role="tabpanel" aria-labelledby="membros-tab">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Período</th>
                                                    <th>Cargo</th>
                                                    <th>Membro</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($members as $item)
                                                <tr>
                                                    <td>{{ date('d/m/Y', strtotime($item->start_date)) . ' - ' . date('d/m/Y', strtotime($item->end_date)) }}</td>
                                                    <td>{{ $item->office->office }}</td>
                                                    <td>{{ $item->councilor->name }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif --}}

                        @if($bidding->progress && count($bidding->progress))
                            <div class="tab-pane fadeshow" id="membros" role="tabpanel" aria-labelledby="membros-tab">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Data/Hora</th>
                                                    <th>Fase</th>
                                                    <th>Membro</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bidding->progress as $item)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($item->datetime)->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>{{ $item->description }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(count($filesBidding) > 0)
                            <div class="tab-pane fadeshow" id="files" role="tabpanel" aria-labelledby="files">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Arquivo</th>
                                                    <th>Tamanho</th>
                                                    <th>Extenção</th>
                                                    <th>Ver</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($filesBidding as $item)
                                                    <tr>
                                                        <td>{{ $item->file->name }}</td>
                                                        <td>
                                                            @if(!empty($item->file->size))
                                                                {{ $item->file->size }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($item->file->format))
                                                                {{ $item->file->format }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ asset('storage/'.$item->file->url) }}" target="_blank">
                                                                <i class="fa-regular fa-eye"></i>
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

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Licitações - Show'])

@include('layouts.footer')

@endsection