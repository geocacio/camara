@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('transparency.show') }}" class="link">Transparência</a>
    </li>
    <li class="item">
        <a href="{{ route('veiculos.show') }}" class="link">Veículos</a>
    </li>
    <li class="item">
        <span>{{ $vehicle->model }}</span>
    </li>
</ul>

<h3 class="title text-center">{{ $vehicle->model }}</h3>

@endsection

@section('content')

@include('layouts.header')
<section class="section-councilor adjust-min-height margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">

                            <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">

                                <div class="row container-descriptions">
                                    <div class="col-md-6">
                                        <p class="title">Modelo do veículo</p>
                                        <p class="description">{{ $vehicle->model }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Marca</p>
                                        <p class="description">{{ $vehicle->brand }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Placa do veículo</p>
                                        <p class="description">{{ $vehicle->plate }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Ano do veículo</p>
                                        <p class="description">{{ $vehicle->year }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Veículo doação</p>
                                        <p class="description">{{ $vehicle->donation }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Situação do veículo</p>
                                        <p class="description">{{ $vehicle->situation }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Tipo do veículo</p>
                                        <p class="description">{{ $vehicle->type }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Finalidade do veículo</p>
                                        <p class="description">{{ $vehicle->purpose_vehicle }}</p>
                                    </div>
                                </div>


                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Veiculo'])

@include('layouts.footer')

@endsection