@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
    </li>
</ul>
<h3 class="title text-center"></h3>
@endsection

@section('content')

@include('layouts.header')

@section('content')

<section>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-post">
                <div class="card-header">
                    <h3 class="mb-3 text-center">{{ $post->title }}</h3>
                    <figure class="img-post">
                        <img src="{{ asset('/img/img_post.jpg')}}" class="mb-5" style="max-height: 300px; width: 100%; object-fit: cover">

                        <ul class="social-media-post">
                            <li>
                                <a href="#" class="email">
                                    <i class="fa-brands fa-google fa-fw"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="facebook">
                                    <i class="fa-brands fa-facebook fa-fw"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="instagram">
                                    <i class="fa-brands fa-instagram fa-fw"></i>
                                </a>
                            </li>
                        </ul>

                        <ul class="list-info-post">
                            <li>
                                <i class="fa-solid fa-tag fa-fw"></i>
                                #Desenvolvimento
                            </li>
                            <li>
                                <i class="fa-solid fa-calendar-days fa-fw"></i>
                                01 De Novembro De 2023
                            </li>
                            <li>
                                <i class="fa-solid fa-eye fa-fw"></i>
                                85
                             </li>
                        </ul>
                    </figure>
                    {{-- @if($image)
                        <img src="{{ asset('storage/'.$image->url)}}" class="mb-5" style="max-height: 300px; width: 100%; object-fit: cover">
                    @endif --}}
                </div>
                <div class="card-body">
                    {!! $post->content !!}
                </div>
                <ul>
                    <li>

                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-list-sidebar">
                <div class="card-body">
                    <ul class="list-post">
                        <h3>Notícias mais vistas</h3>
                        <li>
                            <a href="#">
                                <figure>
                                    <img src="{{ asset('img/Img_post.jpg') }}" />
                                </figure>
                                <div class="info-post-list">
                                    <span class="tags">
                                        <i class="fa-solid fa-tag fa-fw"></i>
                                        #desenvolvimento
                                    </span>
                                    <h3>É assinada Ordem de Serviço de construção do prédio da nova Sede do Poder Legislativo Municipal.</h3>
                                    <span class="hours"><i class="fa-solid fa-clock fa-fw"></i> Há 2 horas</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <figure>
                                    <img src="{{ asset('img/Img_post.jpg') }}" />
                                </figure>
                                <div class="info-post-list">
                                    <span class="tags">
                                        <i class="fa-solid fa-tag fa-fw"></i>
                                        #desenvolvimento
                                    </span>
                                    <h3>É assinada Ordem de Serviço de construção do prédio da nova Sede do Poder Legislativo Municipal.</h3>
                                    <span class="hours"><i class="fa-solid fa-clock fa-fw"></i> Há 2 horas</span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <ul class="list-post">
                        <h3>Notícias mais vistas</h3>
                        <li>
                            <a href="#">
                                <figure>
                                    <img src="{{ asset('img/Img_post.jpg') }}" />
                                </figure>
                                <div class="info-post-list">
                                    <span class="tags">
                                        <i class="fa-solid fa-tag fa-fw"></i>
                                        #desenvolvimento
                                    </span>
                                    <h3>É assinada Ordem de Serviço de construção do prédio da nova Sede do Poder Legislativo Municipal.</h3>
                                    <span class="hours"><i class="fa-solid fa-clock fa-fw"></i> Há 2 horas</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <figure>
                                    <img src="{{ asset('img/Img_post.jpg') }}" />
                                </figure>
                                <div class="info-post-list">
                                    <span class="tags">
                                        <i class="fa-solid fa-tag fa-fw"></i>
                                        #desenvolvimento
                                    </span>
                                    <h3>É assinada Ordem de Serviço de construção do prédio da nova Sede do Poder Legislativo Municipal.</h3>
                                    <span class="hours"><i class="fa-solid fa-clock fa-fw"></i> Há 2 horas</span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <ul class="list-category">
                        <h3>Categorias</h3>
                        <li>
                            <a href="#">
                                <span class="item-category">
                                    <i class="fa-solid fa-tag fa-fw"></i>
                                    Administração
                                </span>
                                <span class="count-category">
                                    12
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="item-category">
                                    <i class="fa-solid fa-tag fa-fw"></i>
                                    Administração
                                </span>
                                <span class="count-category">
                                    12
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="item-category">
                                    <i class="fa-solid fa-tag fa-fw"></i>
                                    Administração
                                </span>
                                <span class="count-category">
                                    12
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="item-category">
                                    <i class="fa-solid fa-tag fa-fw"></i>
                                    Administração
                                </span>
                                <span class="count-category">
                                    12
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="item-category">
                                    <i class="fa-solid fa-tag fa-fw"></i>
                                    Administração
                                </span>
                                <span class="count-category">
                                    12
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@include('pages.partials.satisfactionSurvey', ['page_name' => 'Portal da transparência'])

@include('layouts.footer')

@endsection