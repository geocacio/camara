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
        <a href="{{ route('price.registration.index') }}" class="link">Atas</a>
    </li>
    <li class="item">
        <span>{{ Str::limit($registerPrice->title, '30', '...') }}</span>
    </li>
</ul>

{{-- <h4 class="title-biddings text-center">
    @if(isset($categorieModalidade))
        {{ $categorieModalidade->name }}:
    @endif

    @if(isset($registerPrice) && !empty($registerPrice->number))
        {{ Str::limit($registerPrice->number, '30', '...') }} - EXERCÍCIO:
    @endif

    @if(isset($exercice))
        {{ $exercice->name }} -
    @endif

    @if(isset($registerPrice))
        {{ $registerPrice->status }}
    @endif
</h4> --}}

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
                                Ata de registro de preço
                            </button>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-8">

                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">

                        @if($registerPrice)
                            <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">

                                <h3 class="name-managers">{{ $registerPrice->title }}</h3>
                                <div class="row container-descriptions">
                                    <div class="col-md-6">
                                        <p class="title">Informações do objeto</p>
                                        <p class="description">{{ $registerPrice->object }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">DATA DA ASSINATURA:</p>
                                        <p class="description">{{ date('d/m/Y', strtotime($registerPrice->opening_date)) }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">DATA DA VALIDADE:</p>
                                        <p class="description">{{ date('d/m/Y', strtotime($registerPrice->expiry_date)) }}</p>
                                    </div>
                                    

                                    <div class="col-md-12">
                                        <p class="title">PROCESSO LICITATÓRIO:</p>
                                        <a href="{{ route('bidding.show', $registerPrice->bidding->slug) }}" class="">{{ $registerPrice->bidding->number }}</a>
                                    </div>

                                    <div class="col-12">
                                        <p class="title">INFORMAÇÕES DO CREDOR:</p>

                                        <div class="table-responsive">
                                            <table class="table table-striped table-data-default">
                                                <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>CNPJ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $registerPrice->company->name }}</td>
                                                        <td>{{ $registerPrice->company->cnpj }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    @if($registerPrice->files)
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
                                                    @foreach($registerPrice->files as $item)
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
                                    @endif
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