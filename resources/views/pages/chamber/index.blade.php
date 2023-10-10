@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>A Câmara</span>
    </li>
</ul>

<h3 class="title text-center">A Câmara</h3>

@endsection

@section('content')

@include('layouts.header')

<section class="section-chamber adjust-min-height margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card main-card">
                    <ul class="nav nav-tabs nav-tab-page" id="myTab" role="tablist">
                        @foreach($chamber as $index => $item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $index == 'institutional' ? 'active' : ''}}" id="{{$index}}-tab" data-bs-toggle="tab" data-bs-target="#{{$index}}" type="button" role="tab" aria-controls="home" aria-selected="{{ $index == 'institutional' ? 'true' : 'false'}}">
                                <i class="{{ $item['icon'] }}"></i>
                                {{ $index == 'legislature' ? 'Vereadores' : __($index) }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card main-card">
                    <div class="tab-content" id="myTabContent">

                        @foreach($chamber as $index => $item)
                        <div class="tab-pane fade {{ $index == 'institutional' ? 'show active' : ''}}" id="{{$index}}" role="tabpanel" aria-labelledby="{{$index}}-tab">

                            <h1 class="title-section">{{ $index == 'legislature' ? 'Vereadores' : __($index) }}</h1>

                            @if($index == 'institutional')

                            <div class="row container-descriptions">
                                <div class="col-md-6">
                                    <p class="title">Endereço</p>
                                    <p class="description">{{ $item->address }}, {{ $item->number }} - CEP: {{ $item->cep }} - {{ $item->city }}/{{ $item->state }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Horário</p>
                                    <p class="description">{{ $item->opening_hours }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Telefone</p>
                                    <p class="description">{{ $item->phone }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">E-mail</p>
                                    <p class="description">{{ $item->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Plenário</p>
                                    <p class="description">{{ $item->plenary }}</p>
                                </div>
                            </div>
                            <div class="row container-descriptions">
                                <div class="col-md-6">
                                    Arquivo 1
                                </div>
                                <div class="col-md-6">
                                    Arquivo 2
                                </div>
                            </div>

                            @endif

                            @if($index == 'legislature')

                                @foreach($item['councilors'] as $councilor)
                                
                                    <a href="#" class="councilor-container">
                                        <figure class="figure">
                                            <img class="image" src="{{ asset('storage/'.$councilor->legislatureable->files[0]->file->url) }}" alt="">
                                        </figure>
                                        <div class="info">
                                            <span class="title">{{  $councilor->legislatureable->name }}</span>
                                            <span class="text">Vereador (A)</span>
                                        </div>
                                    </a>
                                
                                @endforeach

                            @endif

                            @if($index == 'boards')

                                @foreach($item['councilors'] as $councilor)
                                
                                    <a href="#" class="councilor-container">
                                        <figure class="figure">
                                            <img class="image" src="{{ asset('storage/'.$councilor->files[0]->file->url) }}" alt="">
                                        </figure>
                                        <div class="info">
                                            <span class="title">{{  $councilor->name }}</span>
                                            <span class="text">{{ $councilor->office->office }}</span>
                                        </div>
                                    </a>
                                
                                @endforeach

                            @endif

                            @if($index == 'commissions')
                            @include('partials.tableDefault', ['data' => $chamber['commissions']['items'], 'actions' => [ 'route' => 'comissoes.single', 'param_type' => 'slug' ] ])
                               {{--  @foreach($item['councilors'] as $councilor)
                                
                                    <a href="#" class="councilor-container">
                                        <figure class="figure">
                                            <img class="image" src="{{ asset('storage/'.$councilor->legislatureable->files[0]->file->url) }}" alt="">
                                        </figure>
                                        <div class="info">
                                            <span class="title">{{  $councilor->legislatureable->name }}</span>
                                            <span class="text">{{  $councilor->legislatureable->office->office }}</span>
                                        </div>
                                    </a>
                                
                                @endforeach --}}

                            @endif

                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'A Câmara'])

@include('layouts.footer')

@endsection