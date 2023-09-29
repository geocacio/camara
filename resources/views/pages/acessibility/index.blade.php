@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        @if($page)
        <span>{{ $page->title }}</span>
        @endif
    </li>
</ul>
@if($page)
<h3 class="title text-center">{{ $page->title}}</h3>
@endif
@endsection

@section('content')

@include('layouts.header')

<section class="section-acessibility margin-fixed-top">
    <div class="container">
        <div class="row">


            @if($page)
            <div class="col-md-12">

                @if($page->description)

                {!! $page->description !!}
                
                <p>Para auxiliar a navegação, foram inseridas algumas teclas de atalho (accesskey) em alguns links. São eles:</p>
                <ul>
                    <li>Voltar para a página inicial (Home Page) - <strong>SHIFT+ALT+H</strong></li>
                    <li>Voltar ao Início (topo da página) - <strong>SHIFT+ALT+K</strong></li>
                    <li>Aumentar Letras - <strong>SHIFT+ALT+F</strong></li>
                    <li>Diminuir Letras - <strong>SHIFT+ALT+G</strong></li>
                    <li>Tamanho Normal das Letras – <strong>SHIFT+ALT+R</strong></li>
                    <li>Alternar entre o modo dia e modo noturno - <strong>SHIFT-ALT-N</strong></li>
                </ul>

                @endif

            </div>
            @endif
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Acessibilidade'])

@include('layouts.footer')

@endsection