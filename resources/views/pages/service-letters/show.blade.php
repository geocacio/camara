@extends('layouts.app')

@section('content')

@include('layouts.header')

@if($serviceLetter)
<section class="section-service-letter adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="breadcrumb">
                    <li class="item">
                        <a href="{{ route('home') }}" class="link">Início</a>
                    </li>
                    <li class="item">
                        <a href="{{ route('transparency.show') }}" class="link">Portal da transparência</a>
                    </li>
                    <li class="item">
                        <a href="{{ route('serviceLetter.page') }}" class="link">Cartas de Serviços</a>
                    </li>
                    <li class="item">
                        <span>{{ $serviceLetter->title }}</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-8">

                <div class="content-default">
                    <ul class="main-style-list">
                        <li class="item">

                            <h3 class="title secondary text-center">{{ $serviceLetter->title }}</h3>
                            <p class="description seconday">{{ $serviceLetter->description }}</p>
                            <div class="container-button">
                                <a href="{{ asset('storage/'.$serviceLetter->files[0]->file->url) }}" target="_blank" class="link default"><i class="fa-solid fa-file"></i><span>Gerar relatório desta carta</span></a>
                            </div>
                        </li>
                    </ul>
                </div>

                @if(!empty(json_decode($serviceLetter->service_letters)))
                @foreach(json_decode($serviceLetter->service_letters) as $index => $items)
                <div class="accordion" id="step-{{$index}}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{$index}}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$index}}" aria-expanded="true" aria-controls="collapse-{{$index}}">
                                {{ $items->input_value }}
                            </button>
                        </h2>
                        @if($items->checklist)
                        <div id="collapse-{{$index}}" class="accordion-collapse collapse show" aria-labelledby="heading-{{$index}}" data-bs-parent="#step-{{$index}}">
                            @php
                                $currentCheckList = explode("\n", $items->textarea_value);
                            @endphp
                            <div class="accordion-body">
                                <ul class="description-list">
                                    @foreach($currentCheckList as $item)
                                        @if($item != '')
                                            <li class="item"><i class="fa-solid fa-square-check"></i>{{$item}}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @else
                        <div id="collapse-{{$index}}" class="accordion-collapse collapse show" aria-labelledby="heading-{{$index}}" data-bs-parent="#step-{{$index}}">
                            <div class="accordion-body">{!! nl2br($items->textarea_value) !!}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif

            </div>

            <div class="col-lg-4">
                <div class="card main">
                    <div class="card-header">
                        <!-- <h3 class="title">Informações da secretaria</h3> -->
                        <h3 class="title text-center">Mais informações</h3>
                        <!-- <h4 class="subtitle">NAn</h4> -->
                    </div>
                    <div class="card-body">
                        <ul class="information-secretary">
                            <li class="item">
                                <i class="fa-regular fa-eye"></i>
                                <div class="description">
                                    <span class="title">Visualizações</span>
                                    <span class="text">{{ $serviceLetter->views }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endif

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Single Cartas de Serviços'])

@include('layouts.footer')


@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log('passou aqui');
    });
</script>
@endsection