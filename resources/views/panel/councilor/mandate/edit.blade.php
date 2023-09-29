@extends('panel.index')
@section('pageTitle', 'Novo Mandato')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
<li><a href="{{ route('mandates.index', 'vereador') }}">Mandatos</a></li>
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
                    <div class="form-group">
                        <label for="current_bond">Cargo</label>
                        <select name="current_bond" class="form-control">
                            <option value="">Selecione</option>
                            <option value="">Vice Presidente</option>
                            <option value="">Vereador (a)</option>
                            <option value="">1º Secretário</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="current_position">Vinculo</label>
                        <select name="current_position" class="form-control">
                            <option value="">Selecione</option>
                            <option value="">Mesa Diretora</option>
                            <option value="">Vereador Exercício</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="current_position">Legislatura</label>
                        <select name="current_position" class="form-control">
                            <option value="">Selecione</option>
                            <option value="">Mesa Diretora</option>
                            <option value="">Vereador Exercício</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="current_bond">Período</label>
                        <select name="current_bond" class="form-control">
                            <option value="">Selecione</option>
                            <option value="">option</option>
                        </select>
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