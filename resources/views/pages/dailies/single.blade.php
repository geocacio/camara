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
        <a href="{{ route('diarias.show') }}" class="link">Diárias</a>
    </li>
    <li class="item">
        <span>{{ $daily ? $daily->number : '' }}</span>
    </li>
</ul>

<h3 class="title text-center">Diária {{ $daily ? $daily->number : ''}}</h3>

@endsection

@section('content')

@include('layouts.header')


<section class="section-single-daily adjust-min-height margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card main-card">
                    <ul class="nav nav-tabs nav-tab-page" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                <i class="fa-solid fa-circle-info"></i>
                                Informações Principais
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                <i class="fa-solid fa-list"></i>
                                Informações da diária
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="trip-tab" data-bs-toggle="tab" data-bs-target="#trip" type="button" role="tab" aria-controls="trip" aria-selected="false">
                                <i class="fa-solid fa-dollar-sign"></i>
                                Informações da Viagem
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documentation-tab" data-bs-toggle="tab" data-bs-target="#documentations" type="button" role="tab" aria-controls="documentations" aria-selected="false">
                                <i class="fa-solid fa-file-pdf"></i>
                                Documentações
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card main-card">
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                            <h1 class="title"><i class="fa-solid fa-circle-info mr-10"></i>Informações Principais</h1>

                            <div class="card-info">
                                @if($daily->ordinance_date)
                                <div class="info">
                                    <h3 class="title-info">Informações da portaria</h3>
                                    <span class="label"><strong>Data da portaria:</strong></span>
                                    <span class="message">{{ date('d/m/Y', strtotime($daily->ordinance_date)) }}</span>
                                </div>
                                @endif

                                @if($daily->agent)
                                <div class="info">
                                    <span class="label"><strong>Agente:</strong></span>
                                    <span class="message">{{ $daily->agent }}</span>
                                </div>
                                @endif

                                @if($daily->office)
                                <div class="info">
                                    <span class="label"><strong>Cargo:</strong></span>
                                    <span class="message">{{ $daily->office->office }}</span>
                                </div>
                                @endif

                                @if($daily->organization_company)
                                <div class="info">
                                    <h3 class="title-info">Informações da diária</h3>
                                    <span class="label"><strong>Orgão\Empresa:</strong></span>
                                    <span class="message">{{ $daily->organization_company }}</span>
                                </div>
                                @endif

                                @if($daily->city)
                                <div class="info">
                                    <span class="label"><strong>Cidade:</strong></span>
                                    <span class="message">{{ $daily->city }}</span>
                                </div>
                                @endif

                                @if($daily->state)
                                <div class="info">
                                    <span class="label"><strong>Estado:</strong></span>
                                    <span class="message">{{ $daily->state }}</span>
                                </div>
                                @endif

                            </div>

                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <h1 class="title"><i class="fa-solid fa-list mr-10"></i>Informações da diária</h1>

                            <div class="card-info">
                                @if($daily->justification)
                                <div class="info">
                                    <h3 class="title-info">Justificativa</h3>
                                    <span class="message">{{ $daily->justification }}</span>
                                </div>
                                @endif

                                @if($daily->historic)
                                <div class="info">
                                    <h3 class="title-info">Histórico</h3>
                                    <span class="message">{{ $daily->historic }}</span>
                                </div>
                                @endif

                            </div>
                        </div>

                        <div class="tab-pane fade" id="trip" role="tabpanel" aria-labelledby="trip-tab">
                            <h1 class="title"><i class="fa-solid fa-dollar-sign mr-10"></i>Informações da viagem</h1>

                            <div class="card-info">
                                @if($daily->trip_start && $daily->trip_end)
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="label"><strong>Início da viagem:</strong></span>
                                            <span class="message">{{ date('d/m/Y', strtotime($daily->trip_start)) }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="label"><strong>Fim da viagem:</strong></span>
                                            <span class="message">{{ date('d/m/Y', strtotime($daily->trip_end)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($daily->payment_date && $daily->unit_price)
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="label"><strong>Data da quitação:</strong></span>
                                            <span class="message">{{ date('d/m/Y', strtotime($daily->payment_date)) }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="label"><strong>Valor unitário:</strong></span>
                                            <span class="message">{{ 'R$ '.number_format($daily->unit_price, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($daily->quantity && $daily->amount)
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="label"><strong>Quantidade:</strong></span>
                                            <span class="message">{{ $daily->quantity }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="label"><strong>Valor total:</strong></span>
                                            <span class="message">{{ 'R$ ' . number_format($daily->amount, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>

                        </div>

                        <div class="tab-pane fade" id="documentations" role="tabpanel" aria-labelledby="documentation-tab">
                            <h1 class="title"><i class="fa-solid fa-file-pdf mr-10"></i>Documentações</h1>
                            @if($daily->files)
                                <div class="group-files">
                                    @foreach($daily->files as $item)
                                        <a class="link" target="_blank" href="{{ asset('storage/'.$item->file->url) }}"><i class="fa-regular fa-file-pdf"></i>{{ $item->file->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Diária'])

@include('layouts.footer')

@endsection