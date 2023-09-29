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
        <span>Manifestações</span>
    </li>
</ul>
<h3 class="title text-center">Consultar manifestação</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.ombudsman.sidebar')

            <div class="col-md-8">
                <div class="card main-card">
                    <h3 class="title">Informações para a consulta</h3>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ $errors->first() }}</li>
                        </ul>
                    </div>
                    @endif

                    <div class="card-body">
                        <form class="form-default" method="post" action="{{ route('manifestacao.search') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="anonymous" type="checkbox" role="switch" id="anonymous" onchange="toggleInput(event)">
                                <label class="form-check-label" for="anonymous">Anônimo</label>
                            </div>
                            <div class="personal-information">
                                <div class="form-group">
                                    <label>CPF</label>
                                    <input type="text" name="cpf" class="form-control mask-cpf" value="{{ old('cpf') }}" />
                                </div>
                                <div class="form-group"><label class="text-center d-block">OU</label></div>
                            </div>

                            <div class="form-group">
                                <label>Protocolo</label>
                                <input type="text" name="protocol" class="form-control mask-protocol" value="{{ old('protocol') }}" />
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

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Buscar Manifestação'])

@include('layouts.footer')

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    
    //mascaras...
    $(document).ready(function() {
        $('.mask-cpf').mask('000.000.000-00');
        $('.mask-protocol').mask('000000000000');
    });

    function toggleInput(e) {
        const personalInformation = document.querySelector('.personal-information');
        if (e.target.checked) {
            personalInformation.style.display = 'none';
        } else {
            personalInformation.style.display = 'block';
        }
    }
</script>
@endsection