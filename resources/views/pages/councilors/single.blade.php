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
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="index-tab" data-bs-toggle="tab" data-bs-target="#index" type="button" role="tab" aria-controls="home" aria-selected="true">
                                <i class="fa-solid fa-user-tie"></i>
                                Título
                            </button>
                        </li>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'A Câmara'])

@include('layouts.footer')

@endsection