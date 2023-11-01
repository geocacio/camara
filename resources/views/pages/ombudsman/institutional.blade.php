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
        <a href="{{ route('ouvidoria.show') }}" class="link">Ouvidoria</a>
    </li>
    <li class="item">
        @if($ombudsman_institutional)
        <span>{{ $ombudsman_institutional->main_title }}</span>
        @endif
    </li>
</ul>
@if($ombudsman_institutional)
<h3 class="title text-center">{{ $ombudsman_institutional->main_title}}</h3>
@endif
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-institutional margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.ombudsman.sidebar')
            @if($ombudsman_institutional)
            <div class="col-md-8">
                <h3 class="secondary-title text-center mb-20">{{ $ombudsman_institutional->title }}</h3>

                @if($ombudsman_institutional->descriptions)
                
                    @foreach(json_decode($ombudsman_institutional->descriptions) as $description)
                        
                        <p class="title">{{ $description->input_value }}</p>

                        @if($description->checklist)

                            @php
                                $currentCheckList = explode("\n", $description->textarea_value);
                            @endphp

                            <ul class="description-list">
                                @foreach($currentCheckList as $item)
                                    @if($item != "")
                                        <li class="item"><i class="fa-solid fa-square-check"></i>{{$item}}</li>
                                    @endif
                                @endforeach
                            </ul>

                        @else

                            <p class="description">{!! nl2br($description->textarea_value) !!}</p>

                        @endif

                    @endforeach

                @endif

            </div>
            @endif
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Institucional'])

@include('layouts.footer')

@endsection