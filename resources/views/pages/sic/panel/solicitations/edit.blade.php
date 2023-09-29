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
        <a href="{{ route('sic.show') }}" class="link">e-SIC</a>
    </li>
    <li class="item">
        <span>Dados cadastrados</span>
    </li>
</ul>
<h3 class="title text-center">Dados cadastrados</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.sic.sidebar')

            <div class="col-md-8">
                <div class="card main-card">

                    <ul class="breadcrumb esic">
                        <li class="item"><a href="{{ route('sic.panel') }}" class="link">e-SIC</a></li>
                        <li class="item">
                            <span>Informações pessoais</span>
                        </li>
                    </ul>

                    <h3 class="title">Informações pessoais</h3>

                    @if (session('feedback-success'))
                    <div class="alert alert-success">
                        {!! session('feedback-success') !!}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ $errors->first() }}</li>
                        </ul>
                    </div>
                    @endif

                    <div class="card-body">
                        <form class="form-default" method="post" action="{{ route('manifestacao.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>Orgão competente</label>
                                <select class="form-control" name="secretary_id">
                                    {{-- @foreach($secretaries as $secretary)
                                            <option value="{{ $secretary->id }}">{{ $secretary->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Métodos de Recebimento de Informações</label>
                                <select class="form-control" id="sex">
                                    <option value="e-mail">Pelo sistema (aviso via E-mail)</option>
                                    <option value="presencial">Presencial</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Resumo da Solicitação</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
                            </div>

                            <div class="form-group">
                                <label>Solicitação</label>
                                <textarea name="solicitation" class="form-control">{{ old('solicitation') }}</textarea>
                            </div>

                            <div class="form-footer text-center">
                                <button type="submit" class="btn-submit-default">Enviar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Solicitação eSIC'])

@include('layouts.footer')

@endsection