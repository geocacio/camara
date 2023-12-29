@extends('panel.index')
@section('pageTitle', 'Nova Receita')

@section('breadcrumb')
<li><a href="{{ route('recipes.index') }}">Receitas</a></li>
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
        <form action="{{ route('recipes.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md">
                <div class="form-group">
                    <label>Tipo de link</label>
                    <select name="link_type" id="type_item" class="form-control">
                        <option value="internal" {{ old('link_type') == 'internal' ? 'selected' : '' }}>Interno</option>
                        <option value="external" {{ old('link_type') == 'external' ? 'selected' : '' }}>Externo</option>
                    </select>
                </div>
            </div>
            <div id="internal_link">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Valor da Receita</label>
                            <input type="text" name="value" class="form-control mask-currency" value="{{ old('value') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data da Receita</label>
                            <input type="date" name="recipe_data" class="form-control" value="{{ old('recipe_data') }}" />
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label>Exercício</label>
                            <input type="text" name="exercise" class="form-control" value="{{ old('exercise') }}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Classificação</label>
                            <input type="text" name="classification" class="form-control" value="{{ old('classification') }}"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Origem</label>
                            <select name="origin" class="form-control">
                                <option value="">Orgão</option>
                                <option value="orcamentaria">Camara municipal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Órgão</label>
                            <select name="organ" class="form-control">
                                <option value="">Orgão</option>
                                <option value="orcamentaria">Camara municipal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipe_type">Tipo de receita</label>
                            <select name="recipe_type" class="form-control">
                                <option value="">Selecione</option>
                                <option value="orcamentaria">Orçamentária</option>
                                <option value="orcamentaria">Extra orçamentária</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Número do talão</label>
                            <input type="number" name="slip_number" class="form-control" value="{{ old('slip_number') }}" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Objeto</label>
                    <textarea name="object" class="form-control">{{ old('object') }}</textarea>
                </div>
            </div>
            <div style="display: none" id="external_link">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipe_type">Título do botão</label>
                            <input type="text" name="text_button" class="form-control" value="{{ old('text_button') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>URL</label>
                            <input type="link" name="url" class="form-control" value="{{ old('url') }}" />
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