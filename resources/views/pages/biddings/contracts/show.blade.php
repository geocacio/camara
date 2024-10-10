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
        <a href="{{ route('contracts.biddings.index') }}" class="link">Contratos</a>
    </li>
    <li class="item">
        <span>Contrato: {{ $contract->number }}</span>
    </li>
</ul>

<h3 class="title text-center">Contrato: {{ $contract->number }}</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-contract-single adjust-min-height margin-fixed-top">
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

                        @if($contract->inspectorContracts->count())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="inspector-tab" data-bs-toggle="tab" data-bs-target="#inspector" type="button" role="tab">
                                <i class="fa-solid fa-suitcase"></i>
                                Inspetores
                            </button>
                        </li>
                        @endif

                        @if($contract->company->bidding->count())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bidding-tab" data-bs-toggle="tab" data-bs-target="#bidding" type="button" role="tab">
                                <i class="fa-solid fa-file-contract"></i>
                                Licitações
                            </button>
                        </li>
                        @endif

                        @if($contract->files)
                        <li class="nav-item" role="presentation">
                            <a href="{{ asset('storage/'.$contract->files->file->url) }}" target="_blank" class="nav-link" id="document-tab">
                                <i class="fa fa-file"></i>                        
                                Documento
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">

                        @if($contract)
                        <div class="tab-pane fade show active" id="index" role="tabpanel" aria-labelledby="index-tab">

                            <h3 class="name-contract">Contrato: {{ $contract->number }}</h3>

                            <div class="row container-descriptions">
                                <div class="col-md-6">
                                    <p class="title">Empresa</p>
                                    {{ $contract->company ? $contract->company->name : 'Empresa não cadastrada' }}
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Data de Início</p>
                                    <p class="description">{{ date('d/m/Y', strtotime($contract->start_date)) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Data de Término</p>
                                    <p class="description">{{ date('d/m/Y', strtotime($contract->end_date)) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Valor Total</p>
                                    <p class="description">{{ number_format($contract->total_value, 2, ',', '.') }}</p>
                                </div>
                                <div class="col-md-12">
                                    <p class="title">Descrição</p>
                                    <p class="description">{{ $contract->description }}</p>
                                </div>
                            </div>

                        </div>
                        @endif

                        @if($contract->inspectorContracts)
                        <div class="tab-pane fade" id="inspector" role="tabpanel" aria-labelledby="inspector-tab">

                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-data-default">
                                        <thead>
                                            <tr>
                                                <th>Nome do Inspetor</th>
                                                <th>Observação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($contract->inspectorContracts as $inspectorContract)
                                            <tr>
                                                <td>{{ $inspectorContract->inspector->name }}</td>
                                                <td>{{ $inspectorContract->observation }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        @endif

                        @if($contract->company->bidding->count())
                            <div class="tab-pane fade" id="bidding" role="tabpanel" aria-labelledby="bidding-tab">

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Número da Licitação</th>
                                                    <th>Modalidade</th>
                                                    <th>Mais</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $categorieModalidade->created_at->format('d/m/Y') ?? 'N/A' }}</td>
                                                    <td>{{ $bidding->number ?? 'N/A' }}</td>
                                                    <td>{{ $categorieModalidade->name ?? 'N/A' }}</td>
                                                    <td style="cursor: pointer"> 
                                                        <a href="{{ route('bidding.show', $bidding->slug) }}">
                                                            <i class="fa-regular fa-eye"></i>
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

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Contrato'])

@include('layouts.footer')

@endsection
