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

            <div class="col-md-5">
                {{-- <h3 class="secondary-title text-center mb-20">{{ $esicPage->title }}</h3> --}}

                <span class="last-edition">
                    <div class="line-blue"></div>
                    Expediente
                </span>
                <div class="box-expedient">
                    <div class="container-expedient">
                        <h6 class="title-expedient">ACERVO</h6>
                        <span class="content-expedient">{{ $officeHour->information }}</span>
                    </div>

                    <div class="container-expedient">
                        <h6 class="title-expedient">PERIODICIDADE</h6>
                        <span class="content-expedient">{{ $officeHour->frequency }}</span>
                    </div>

                    <div class="container-expedient">
                        <h6 class="title-expedient">RESPONSÁVEL</h6>
                        <span class="content-expedient">{{ $officeHour->responsible_name }}</span>
                        <span class="content-expedient">{{ $officeHour->responsible_position }}</span>
                    </div>

                    <div class="container-expedient">
                        <h6 class="title-expedient">ENTIDADE</h6>
                        <span class="content-expedient">{{ $officeHour->entity_name }}</span>
                        <span class="content-expedient">{{ $officeHour->entity_address }}</span>
                        <span class="content-expedient">CEP:{{ $officeHour->entity_zip_code }} CNPJ:{{ $officeHour->entity_cnpj }}</span>
                        <span class="content-expedient">Email:{{ $officeHour->entity_email }} Telefone: {{ $officeHour->entity_phone }}</span>
                    </div>
                </div>

                @if (session('feedback-success'))
                <div class="alert alert-success">
                    {!! session('feedback-success') !!}
                </div>
                @endif                
            </div>
            @if($dayle->files->count() > 0)
                @include('pages.official-diary.diary-component', ['single' => true])
            @endif
    </div>
</section>

{{-- @include('pages.partials.satisfactionSurvey', ['page_name' => 'Normativas']) --}}

@include('layouts.footer')

@endsection
