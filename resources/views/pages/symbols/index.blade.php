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
        <span>{{ $pageSymbol ? $pageSymbol->main_title : '' }}</span>
    </li>
</ul>

<h3 class="title text-center">{{ $pageSymbol ? $pageSymbol->main_title : ''}}</h3>

@endsection

@section('content')

@include('layouts.header')

@php
    $brasao = null;
    $bandeira = null;
    if($symbol && $symbol->files && $symbol->files->count() > 0){
        foreach($symbol->files as $file){
            $brasao = $file->file->name == 'Brasão' ? $file->file : $brasao;
            $bandeira = $file->file->name == 'Bandeira' ? $file->file : $bandeira;
        }
    }
@endphp

<section class="section-symbols adjust-min-height margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card main-card card-manager">
                    <ul class="nav nav-tabs nav-tab-page" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                <i class="fa-solid fa-music"></i>
                                Hino
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                <i class="fa-solid fa-shield"></i>
                                Brazão
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                                <i class="fa-solid fa-flag"></i>
                                Bandeira
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">

                        @if($symbol)
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="box-content-tab symbols">

                                <h1 class="title-section">Hino</h1>
                                @if($symbol && $symbol->himn_url != '')
                                    @php
                                        if (parse_url($symbol->himn_url, PHP_URL_QUERY)) {
                                            // Obter a query string do URL
                                            $urlQuery = parse_url($symbol->himn_url, PHP_URL_QUERY);

                                            // Extrair os parâmetros da query string
                                            parse_str($urlQuery, $url);

                                            // O ID do vídeo estará disponível em $url['v']
                                            $videoID = isset($url['v']) ? $url['v'] : '';
                                        } else {
                                            // O URL não contém uma query string, então o ID do vídeo é obtido diretamente do caminho (path)
                                            $videoID = basename(parse_url($symbol->himn_url, PHP_URL_PATH));
                                        }
                                    @endphp

                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$videoID}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                @endif

                                @if($symbol && $symbol->himn != '')
                                <div class="text-page">{{ $symbol->himn }}</div>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($brasao)
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="box-content-tab">

                                <h1 class="title-section">Brazão</h1>

                                <a href="#" class="img-city-hall">
                                    <img src="{{ asset('storage/'.$brasao->url) }}">
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($bandeira)
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="box-content-tab">

                                <h1 class="title-section">Bandeira</h1>

                                <a href="#" class="img-city-hall">
                                    <img src="{{ asset('storage/'.$bandeira->url) }}">
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Simbolos'])

@include('layouts.footer')

@endsection