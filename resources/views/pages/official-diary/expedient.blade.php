@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('official.diary.page') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('expediente.show') }}" class="link">expediente</a>
    </li>
</ul>
<h3 class="title text-center">Diário Oficial Eletrônico</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-diary margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.official-diary.sidebar')
            @if($officeHour)
                <div class="col-md-8">
                    <h3 class="title-journal mb-20">Expediente</h3>
                    <div class="card main-card card-manager">
                        <div class="tab-content" id="myTabContent">
                            <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">

                                {{-- <h3 class="name-managers">{{ $bidding->description }}</h3> --}}

                                <div class="row container-descriptions">
                                    <div class="col-md-12">
                                        <h6>Acervo</h6>
                                        <p class="description">{{ $officeHour->information ?? '' }}</p>
                                    </div>

                                    <div class="col-12">
                                        <div class="office-hours">
                                            <p><strong>PERIODICIDADE:</strong> {{ $officeHour->frequency }}</p>
                                            <p><strong>RESPONSÁVEL:</strong> {{ $officeHour->responsible_name ?? 'N/A' }}</p>
                                            <p><strong>Cargo do responsável:</strong> {{ $officeHour->responsible_position ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction:row;">
                                        <div class="col-6">
                                            <div class="row">
                                                <div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <strong>Entidade:</strong> {{ $officeHour->entity_name }}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <strong>Endereço:</strong> {{ $officeHour->entity_address ?? '' }}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <strong>Cep:</strong> {{ $officeHour->entity_zip_code ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div>
                                                    <br/>
                                                    <div class="row">                                             
                                                        <div class="col-md-12">
                                                            <strong>CNPJ:</strong> {{ $officeHour->entity_cnpj ?? '' }}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <strong>Telefone:</strong> {{ $officeHour->entity_phone ?? '' }}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <strong>Email:</strong> {{ $officeHour->entity_email ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('feedback-success'))
                    <div class="alert alert-success">
                        {!! session('feedback-success') !!}
                    </div>
                    @endif                
                </div>
                {{-- @if($dayle && $dayle->files->count() > 0)
                    @include('pages.official-diary.diary-component', ['single' => true])
                @endif --}}
            @endif
    </div>
</section>

{{-- @include('pages.partials.satisfactionSurvey', ['page_name' => 'Normativas']) --}}

@include('layouts.footer')

@endsection
