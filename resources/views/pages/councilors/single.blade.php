@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('home') }}" class="link">Vereadores</a>
    </li>
    <li class="item">
        <span>A Câmara</span>
    </li>
</ul>

<h3 class="title text-center">A Câmara</h3>

@endsection

@section('content')

@include('layouts.header')
{{-- {{ dd($councilor->legislatureRelations)}} --}}
<section class="section-chamber adjust-min-height margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card main-card">
                    <ul class="nav nav-tabs nav-tab-page" id="myTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="index-tab" data-bs-toggle="tab" data-bs-target="#index" type="button" role="tab">
                                <i class="fa-solid fa-user-tie"></i>
                                Título
                            </button>
                        </li>

                        @if($councilor->materials)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="legislative-tab" data-bs-toggle="tab" data-bs-target="#legislative" type="button" role="tab">
                                <i class="fa-solid fa-copy"></i>
                                Produção legislativa
                            </button>
                        </li>
                        @endif

                        @if($councilor->sessionAttendance)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="session-tab" data-bs-toggle="tab" data-bs-target="#session" type="button" role="tab">
                                <i class="fa-solid fa-microphone"></i>
                                Sessões
                            </button>
                        </li>
                        @endif

                        @if($councilor->commissionLinks)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="commission-tab" data-bs-toggle="tab" data-bs-target="#commission" type="button" role="tab">
                                <i class="fa-solid fa-users"></i>
                                Comissões
                            </button>
                        </li>
                        @endif

                        @if($councilor->legislatureRelations)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="legislature-tab" data-bs-toggle="tab" data-bs-target="#legislature" type="button" role="tab">
                                <i class="fa-solid fa-suitcase"></i>
                                Legislaturas
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-8">

                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">

                            <h1 class="title">Prefeito</h1>

                            <ul class="manager-networks">
                                <li>
                                    <a href="https://www.instagram.com/gledsonlimabezerra/" target="_blank" class="email">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/gledson.bezerra.9" target="_blank" class="phone">
                                        <i class="fa-solid fa-phone"></i>
                                    </a>
                                </li>
                            </ul>

                            <figure class="img-managers">
                                <img src="http://127.0.0.1:9000/storage/managers/1695380684_gestor_2_610151252.jpg" class="">
                            </figure>
                            <h3 class="name-managers">GLÊDSON LIMA BEZERRA</h3>

                            <div class="row container-descriptions">
                                <div class="col-md-6">
                                    <p class="title">Cargo atual</p>
                                    <p class="description">PRESIDENTE</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Vínculo atual</p>
                                    <p class="description">MESA DIRETORA</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Desde</p>
                                    <p class="description">01/01/2023</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Nascimento</p>
                                    <p class="description">25/04/1978</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Naturalidade</p>
                                    <p class="description">MARCO</p>
                                </div>
                            </div>


                        </div>

                        @if($councilor->materials)
                            <div class="tab-pane fadeshow" id="legislative" role="tabpanel" aria-labelledby="legislative-tab">

                                @foreach($councilor->materials as $material)

                                    <div class="col-md-12">
                                        <div class="card-with-links">
                                            <a href="{{ route('materiais.single', $material->slug) }}">
                                                <div class="header">
                                                    <i class="fa-solid fa-copy"></i>
                                                </div>
                                                <div class="second-part">
                                                    <div class="body">
                                                        <h3 class="title">{{ $material->type->name }}</h3>
                                                        <p class="description">{{ Str::limit($material->description, '75', '...') }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        @endif

                        @if($councilor->sessionAttendance)
                        
                            <div class="tab-pane fadeshow" id="session" role="tabpanel" aria-labelledby="session-tab">

                                @foreach($councilor->sessionAttendance as $session)
                                    
                                    <div class="col-md-12">
                                        <div class="card-with-links">
                                            <a href="{{ route('comissoes.single', $session->session->slug) }}">
                                                <div class="header">
                                                    <i class="fa-solid fa-microphone"></i>
                                                </div>
                                                <div class="second-part">
                                                    <div class="body">
                                                        <h3 class="title">{{ $session->session->types[0]->name . ': ' . $session->session->id . '/' . date('Y', strtotime($session->session->created_at)) }}</h3>
                                                        <p class="description">{{ Str::limit($session->session->description, '75', '...') }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        @endif

                        @if($councilor->commissionLinks)
                        
                            <div class="tab-pane fadeshow" id="commission" role="tabpanel" aria-labelledby="commission-tab">

                                @foreach($councilor->commissionLinks as $commission)
                                    
                                    <div class="col-md-12">
                                        <div class="card-with-links">
                                            <a href="{{ route('comissoes.single', $commission->commission->slug) }}">
                                                <div class="header">
                                                    <i class="fa-solid fa-users"></i>
                                                </div>
                                                <div class="second-part">
                                                    <div class="body">
                                                        <h3 class="title text-left">{{ $commission->commission->description }}</h3>
                                                        <p class="description">{{ Str::limit($commission->commission->information, '75', '...') }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        @endif

                        @if($councilor->legislatureRelations)
                            <div class="tab-pane fadeshow" id="legislature" role="tabpanel" aria-labelledby="legislature-tab">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    <th>Cargo</th>
                                                    <th>Vínculo</th>
                                                    <th>Legislatura</th>
                                                    <th>Período</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            
                                                @foreach($councilor->legislatureRelations as $legislature)
                                                <tr>
                                                    <td>{{ $legislature->office->office }}</td>
                                                    <td>{{ $legislature->category->name }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($legislature->legislature->start_date)) . ' - ' . date('d/m/Y', strtotime($legislature->legislature->end_date)) }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($legislature->first_period)) . ' - ' . date('d/m/Y', strtotime($legislature->final_period)) }}</td>
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

@include('pages.partials.satisfactionSurvey', ['page_name' => 'A Câmara'])

@include('layouts.footer')

@endsection