@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('sessoes-all') }}" class="link">Sessões</a>
    </li>
    <li class="item">
        <span>{{ $session->slug }}: {{ $session->id }}/{{ date('Y', strtotime($session->date)) }}</span>
    </li>
</ul>

<h3 class="title text-center">{{ $session->slug }}: {{ $session->id }}/{{ date('Y', strtotime($session->date)) }}</h3>

@endsection

@section('content')

@include('layouts.header')

<section class="section-session-single adjust-min-height margin-fixed-top">
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

                        @if($session->sessionAttendance)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tramite-tab" data-bs-toggle="tab" data-bs-target="#tramite" type="button" role="tab">
                                <i class="fa-solid fa-suitcase"></i>
                                Chamada dos vereadores
                            </button>
                        </li>
                        @endif

                        @if($session->proceedings)
                            @foreach($session->proceedings as $proceeding)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#proceeding-{{ $proceeding->id }}" type="button" role="tab">
                                        <i class="fa-solid fa-copy"></i>
                                        {{ $proceeding->category->name }}
                                    </button>
                                </li>
                        @endforeach
                        @endif
                        
                    </ul>
                </div>
            </div>
            <div class="col-md-8">

                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">

                        @if($session)
                            <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">

                                <h3 class="name-managers">{{ $session->slug }}: {{ $session->id }}/{{ date('Y', strtotime($session->date)) }}</h3>

                                <div class="row container-descriptions">
                                    <div class="col-md-6">
                                        <p class="title">Autor</p>
                                        <p class="description">{{ $session->slug}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Data</p>
                                        <p class="description">{{ date('d/m/Y', strtotime($session->date)) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Visualizações</p>
                                        <p class="description">{{ $session->views }}</p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="title">Resumo</p>
                                        <p class="description">{{ $session->description }}</p>
                                    </div>
                                </div>


                            </div>
                        @endif

                        @if($session->sessionAttendance)
                            <div class="tab-pane fadeshow" id="tramite" role="tabpanel" aria-labelledby="tramite-tab">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-data-default">
                                            <thead>
                                                <tr>
                                                    {{-- <th>Cargo</th> --}}
                                                    <th>Nome</th>
                                                    <th>Chamada</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($session->sessionAttendance as $call)
                                                <tr>
                                                    {{-- <td>{{ $call->councilor->name }}</td> --}}
                                                    <td>{{ $call->councilor->name }}</td>
                                                    <td><span class="call-status {{ strtolower($call->call) }}"></span>{{ $call->call }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($session->proceedings)
                        
                            @foreach($session->proceedings as $proceeding)
                        
                                <div class="tab-pane fadeshow" id="proceeding-{{ $proceeding->id }}" role="tabpanel" aria-labelledby="materials-tab">
                                    @foreach($proceeding->progress as $progress)
                                    <div class="col-md-12">
                                        <div class="card-with-links">
                                            <a href="#">
                                                <div class="header">
                                                    <i class="fa-solid fa-copy"></i>
                                                </div>
                                                <div class="second-part">
                                                    <div class="body">
                                                        <h3 class="title">{{ $progress->material->type->name }}: {{ $progress->material->id }}/{{ date('Y', strtotime($progress->material->date)) }}</h3>
                                                        <p class="description">{{ Str::limit($progress->material->description, '75', '...') }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                    
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Sessão'])

@include('layouts.footer')

@endsection