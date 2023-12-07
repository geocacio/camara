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
@if(isset($chamber))

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
                                        <p class="description">{{ isset($item['address']) ? $item['address'].', ' : '' }} {{ isset($item['number']) ? $item['number'] : '' }} {{ isset($item['cep']) ? '- CEP:'.$item['cep'] : '' }} {{ isset($item['city']) ? ' - '.$item['city'] : '' }}{{ isset($item['state']) ? '/'.$item['state'] : '' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Horário</p>
                                        <p class="description">{{ isset($item['opening_hours']) ? $item['opening_hours'] : '' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Telefone</p>
                                        <p class="description">{{ isset($item['phone']) ? $item['phone'] : '' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">E-mail</p>
                                        <p class="description">{{ isset($item['email']) ? $item['email'] : '' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="title">Plenário</p>
                                        <p class="description">{{ isset($item['plenary']) ? $item['plenary'] : '' }}</p>
                                    </div>
                                </div>
                                {{-- <div class="row container-descriptions">
                                    <div class="col-md-6">
                                        Arquivo 1
                                    </div>
                                    <div class="col-md-6">
                                        Arquivo 2
                                    </div>
                                </div> --}}

                            @endif

                            @if($index == 'legislature')
                                <div class="row gd-councilor-container">
                                    @foreach($item['councilors'] as $councilor)
                                        <div class="col-lg-6">
                                            <a href="{{ route('vereador.single', $councilor->legislatureable->slug) }}" class="councilor-items">
                                                @if($councilor->legislatureable->files && count($councilor->legislatureable->files) > 0)
                                                <figure class="figure">
                                                    <img class="image" src="{{ asset('storage/'.$councilor->legislatureable->files[0]->file->url) }}" alt="">
                                                </figure>
                                                @endif
                                                <div class="info">
                                                    <span class="title">{{  $councilor->legislatureable->surname }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                            @endif

                            @if($index == 'boards')
                                <div class="row gd-councilor-container">
                                    @foreach($item['councilors'] as $councilor)
                                        <div class="col-lg-6">
                                            <a href="{{ route('vereador.single', $councilor->slug) }}" class="councilor-items">
                                                @if($councilor->files && count($councilor->files) > 0)
                                                <figure class="figure">
                                                    <img class="image" src="{{ asset('storage/'.$councilor->files[0]->file->url) }}" alt="">
                                                </figure>
                                                @endif
                                                <div class="info">
                                                    <span class="title">{{  $councilor->name }}</span>
                                                    <span class="text">{{ $councilor->legislatureRelations[0]->office->office }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                            @endif

                            @if($index == 'sectors')

                                <div class="accordion" id="accordionSector">
                                    @foreach($chamber['sectors']['items'] as $sector)
                                        
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-{{ $sector->id }}">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $sector->id }}" aria-expanded="true" aria-controls="collapse-{{ $sector->id }}">
                                                    <span>{{ $sector->name }}</span>
                                                </button>
                                            </h2>
                                            <div id="collapse-{{ $sector->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : ''}}" aria-labelledby="heading-{{ $sector->id }}" data-bs-parent="#accordionSector">
                                                <div class="accordion-body">
                                                    <ul class="sector-list">
                                                        <li class="item">
                                                            <i class="fa-solid fa-envelope"></i>
                                                            <span class="text">{{ $sector->email }}</span>    
                                                        </li>
                                                        <li class="item">
                                                            <i class="fa-solid fa-phone"></i>
                                                            <span class="text">{{ $sector->phone }}</span>    
                                                        </li>
                                                    </ul>    
                                                </div>
                                            </div>
                                        </div>
                                    
                                    @endforeach
                                </div>

                            @endif

                            @if($index == 'commissions')
                                @include('partials.tableDefault', ['data' => $chamber['commissions']['items'], 'actions' => [ 'route' => 'comissoes.single', 'param_type' => 'slug' ] ])
                            @endif

                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endif

@include('pages.partials.satisfactionSurvey', ['page_name' => 'A Câmara'])

@include('layouts.footer')

@endsection