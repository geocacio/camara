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
<h3 class="title text-center">Expediente</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-diary margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.official-diary.sidebar')
            @if($officeHour)
                <div class="col-md-8">
                    {{-- <h3 class="secondary-title text-center mb-20">{{ $esicPage->title }}</h3> --}}
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
                                        <div class="table-responsive">
                                            <table class="table table-striped table-data-default">
                                                <thead>
                                                    <tr>
                                                        <th>PERIODICIDADE</th>
                                                        <th>RESPONSÁVEL</th>
                                                        <th>Cargo do responsável</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                
                                                    <tr>
                                                        <td>{{ $officeHour->frequency }}</td>
                                                        <td>{{ $officeHour->responsible_name  ?? '' }}</td>
                                                        <td>{{ $officeHour->responsible_position ?? '' }}</td>
                                                    </tr>
                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <p class="title">Sobre a câmara:</p>
                                    <br/>
                                    <br/>

                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-data-default">
                                                <thead>
                                                    <tr>
                                                        <th>Entidade</th>
                                                        <th>Endereço</th>
                                                        <th>Cep</th>
                                                        <th>CNPJ</th>
                                                        <th>Telefone</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                
                                                    <tr>
                                                        <td>{{ $officeHour->entity_name }}</td>
                                                        <td>{{ $officeHour->entity_address  ?? '' }}</td>
                                                        <td>{{ $officeHour->entity_zip_code  ?? '' }}</td>
                                                        <td>{{ $officeHour->entity_cnpj ?? '' }}</td>
                                                        <td>{{ $officeHour->entity_phone ?? '' }}</td>
                                                        <td>{{ $officeHour->entity_email ?? '' }}</td>
                                                    </tr>
                                
                                                </tbody>
                                            </table>
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
