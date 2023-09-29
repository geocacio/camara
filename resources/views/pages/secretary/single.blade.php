@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('secretarias.show') }}" class="link">Secretarias</a>
    </li>
    <li class="item">
        <span>{{ $secretary->name }}</span>
    </li>
</ul>

<h3 class="title text-center main">{{ $secretary->name }}</h3>
@endsection

@section('content')

@include('layouts.header')



<section class="section-secretary adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card main-card">
                    <div class="header-sidebar">
                        <a href="#">
                            <figure>
                                <img scr="https://saude.goiania.go.gov.br/wp-uploads/sites/3/2021/02/durval-ferreira-1024x682.jpeg"/>
                            </figure>
                            <div class="info-secretary">
                                <h4>Secretário</h4>
                                <h1>Durval Ferreira Fonseca Pedroso</h1>
                            </div>
                        </a>
                    </div>
                    <ul class="list-contact-secretary">
                        <li>
                            <i class="fa-solid fa-phone fa-fw"></i>
                            (62) 3524-1570 ou 3524-1577
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope fa-fw"></i>
                            sms@goiania.go.gov.br
                        </li>
                        <li>
                            <i class="fa-solid fa-clock fa-fw"></i>
                            Segunda a Sexta das 8h às 18h
                        </li>
                        <li>
                            <i class="fa-solid fa-location-dot fa-fw"></i>
                            Paço Municipal - Avenida do Cerrado, n° 999 - Bloco D, 2º andar, Parque Lozandes - Goiânia – GO CEP 74.884-900
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card main-card">
                    <h1 class="title">Competências</h1>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => $secretary->name ])

@include('layouts.footer')

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $('.mask-date').mask('00-00-0000');
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection