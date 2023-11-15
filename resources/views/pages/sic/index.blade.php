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
        <span>eSIC</span>
    </li>
</ul>
<h3 class="title text-center">{{ $esicPage->main_title }}</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-sic margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.sic.sidebar')

            <div class="col-md-8">
                <h3 class="secondary-title text-center mb-20">{{ $esicPage->title }}</h3>

                @if (session('feedback-success'))
                <div class="alert alert-success">
                    {!! session('feedback-success') !!}
                </div>
                @endif

                <p class="description text-justify">{{ $esicPage->description }}</p>

                <div class="row">
                    <div class="col-md-6">
                        <p class="title">Gestor</p>
                        <p class="description">{{ isset($sic->manager) ? $sic->manager : ''; }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="title">Telefone</p>
                        <p class="description">{{ isset($sic->phone) ? $sic->phone : '' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="title">E-mail</p>
                        <p class="description">{{ isset($sic->email) ? $sic->email : '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="title">CEP</p>
                        <p class="description">{{ isset($sic->cep) ? $sic->cep : '' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="title">Endereço</p>
                        <p class="description">{{ isset($sic->street) ? $sic->street : '' }} nº{{ isset($sic->number) ? $sic->number : '' }} - {{ isset($sic->neighborhood) ? $sic->neighborhood : '' }} {{ isset($sic->complement) ? $sic->complement : '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="title">Horário de atendimento</p>
                        <p class="description">{{ isset($sic->opening_hours) ? $sic->opening_hours : '' }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'eSIC'])

@include('layouts.footer')

@endsection