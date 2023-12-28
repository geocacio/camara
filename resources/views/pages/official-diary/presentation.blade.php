@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('official.diary.page') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('official.diary.presentation') }}" class="link">{{ $presentation->name }}</a>
    </li>
</ul>
<h3 class="title text-center">{{ $presentation->name }}</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-diary margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.official-diary.sidebar')

            <div class="col-md-6">
                {{-- <h3 class="secondary-title text-center mb-20">{{ $esicPage->title }}</h3> --}}

                @if (session('feedback-success'))
                <div class="alert alert-success">
                    {!! session('feedback-success') !!}
                </div>
                @endif

                <p class="title-journal">Diário Oficial Eletrônico</p>
                <span class="last-edition">
                    <div class="line-blue"></div>
                    {{ $presentation->name   }}
                </span>

                <p class="desc-journal">
                    {{ $law->description   }}
                </p>

            </div>
            
            {{-- <div class="col-md-3">
                <span class="last-edition">
                    <div class="line-blue"></div>
                    Última edição
                </span>
                <div class="box-dowload card main-card">
                    <h6>DIÁRIO OFICIAL ELETRÔNICO</h6>
                    <div class="circle">
                        <i class="fa fa-file-contract"></i>
                    </div>
                    <span>{{ $dayle->created_at->format('d/m/Y H:i:s') }}</span>

                    <button class="dowload-journal">
                        @if($dayle->files->count() > 0)
                            <a href="{{ asset('storage/'.$dayle->files[0]->file->url) }}" target="_blank">
                                <i class="fa fa-download"></i>                        
                                Baixar
                            </a>
                        @endif
                    </button>
                </div>
            </div> --}}
        </div>
    </div>
</section>

{{-- @include('pages.partials.satisfactionSurvey', ['page_name' => 'Normativas']) --}}

@include('layouts.footer')

@endsection


<style>
    
    .box-dowload {
        /* height: 100%!important; */
        transition: all ease-out 0.6s;
        color: #30358c;
        align-items: center;
        gap: 4vh;
    }
    
    .box-dowload:hover {
        background-color: #30358c;
        cursor: pointer;
        color: white;
    }

    .box-dowload:hover h6 {
        color: white;
    }

    .box-dowload:hover .circle {
        background-color: white;
        color: #30358c;
    }

    .box-dowload h6 {
        color: #30358c;
        text-align: center;
    }

    .title-journal {
        color: #0000cd;
        font-size: 28px;
        padding-bottom: 20px;
        font-family: sans-serif;
        font-weight: bold;
    }

    .desc-journal {
        font-family: "Lato", sans-serif;
        color: #777;
    }

    .circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #30358c;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 34px;
        color: white;
    }

    .dowload-journal {
        /* display: none; */
        width: 100%;
        height: 40px;
        background-color: #191b3d;
        border: none;
        border-radius: 5px;
        margin-top: 20px;
    }

    .dowload-journal a {
        color: #fff!important;
    }


    .line-blue {
        width: 10px!important;
        height: 2px;
        background-color: #30358c;
    }

    .last-edition {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 13px;
        margin-bottom: 20px;
    }
</style>