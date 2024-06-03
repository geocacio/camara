@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('official.diary.page') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('official.diary.normative') }}" class="link">{{ $normative->name ?? '' }}</a>
    </li>
</ul>
<h3 class="title text-center">{{ $normative->name ?? '' }}</h3>
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

                <div class="card main-card card-manager" style="min-height: 358;">
                    <div class="tab-content" id="myTabContent">
                        <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">
                            <p class="title-journal">Diário Oficial Eletrônico</p>
                            
                            <span class="last-edition">
                                <div class="line-blue"></div>
                                Normativas de Publicação
                            </span>

                            <div style="text-align: justify">{{ $normative->normatives ?? '' }}</div>

                            <div class="files mt-3">
                                @foreach ($files as $file)
                                    {{-- <h6 class="truncate-text">
                                        <a title="Ver arquivo pdf" href="{{ asset('storage/'.$file->url) }}" target="_blank">
                                            {{ $file->description }}
                                        </a>
                                    </h6> --}}
                                    <div class="box-de">
                                        <div class="item-de">
                                            <p class="item-title-de"> {{ $file->description }}</p>
                                            <div class="item-actions-de">
                                                <span><input type="checkbox" checked disabled> Ativo</span>
                                                <a href="{{ asset('storage/'.$file->url) }}"  target="_blank" class="download-link-de"><i class="fa-solid fa-download"></i> Baixar</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                        </div>
                    </div>
                </div>

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
    .box-dowload h6 {
        color: #30358c;
        text-align: center;
    }

    .title-journal {
        color: #0000cd;
        font-size: 28px;
        padding-bottom: 5px;
        font-family: sans-serif;
        font-weight: bold;
    }

    .desc-journal {
        font-family: "Lato", sans-serif;
        color: #777;
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
    .truncate-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .truncate-text:hover {
        white-space: normal;
        overflow: visible;
    }

    .box-de {
        background-color: #f9f9f9;
        border-radius: 8px;
        /* padding: 20px; */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .item-de {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .item-title-de {
        font-weight: bold;
        color: #333333;
        margin: 0 0 10px 0;
    }

    .item-actions-de {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        color: #666666;
    }

    .item-actions-de span {
        display: flex;
        align-items: center;
    }

    .item-actions-de input {
        margin-right: 5px;
    }

    .download-link-de {
        text-decoration: none;
        color: #007bff;
    }

    .download-link-de:hover {
        text-decoration: underline;
    }

</style>