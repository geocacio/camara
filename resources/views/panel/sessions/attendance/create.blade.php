@extends('panel.index')
@section('pageTitle', 'Novo Vereador')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
<li><span>Novo</span></li>
@endsection

@section('content')
<div class="card">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <li>{{ $errors->first() }}</li>
        </ul>
    </div>
    @endif

    <div class="card-body">
        <form action="#" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group group-inline-form">
                        <figure class="img-councilor-list">
                            <img src="https://www.camaramunicipaldemarco.ce.gov.br/imagens/6.jpg"/>
                        </figure>

                        <div class="align-center">
                            <h1>SOCORRO OSTERNO</h1>
                            <div class="text-left">
                                <label class="cursor-pointer" for="toggle">Ausente/Presente</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" id="toggle" name="visibility" value="" class="toggle-input">
                                    <label for="toggle" class="toggle-label"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

@include('panel.scripts')

@endsection