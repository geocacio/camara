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
        <form action="{{ route('recipes.update', $recipe->id) }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Valor da Receita</label>
                        <input type="text" name="value" class="form-control mask-currency" value="{{ $recipe->value }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data da Receita</label>
                        <input type="date" name="recipe_data" class="form-control" value="{{ $recipe->recipe_data }}" />
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label>Exercício</label>
                        <input type="text" name="exercise" class="form-control" value="{{ $recipe->exercise }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Classificação</label>
                        <input type="text" name="classification" class="form-control" value="{{ $recipe->classification }}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Origem</label>
                        <select name="origin" class="form-control">
                            <option value="" {{ old('organ', $recipe->organ) == '' ? 'selected' : '' }}>Orgão</option>
                            <option value="orcamentaria" {{ old('organ', $recipe->organ) == 'orcamentaria' ? 'selected' : '' }}>Camara municipal</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="organ">Órgão</label>
                        <select name="organ" class="form-control">
                            <option value="" {{ old('organ', $recipe->organ) == '' ? 'selected' : '' }}>Orgão</option>
                            <option value="orcamentaria" {{ old('organ', $recipe->organ) == 'orcamentaria' ? 'selected' : '' }}>Camara municipal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="recipe_type">Tipo de receita</label>
                        <select name="recipe_type" class="form-control">
                            <option value="" {{ old('recipe_type', $recipe->recipe_type) == '' ? 'selected' : '' }}>Selecione</option>
                            <option value="orcamentaria" {{ old('recipe_type', $recipe->recipe_type) == 'orcamentaria' ? 'selected' : '' }}>Orçamentária</option>
                            <option value="extraorcamentaria" {{ old('recipe_type', $recipe->recipe_type) == 'extraorcamentaria' ? 'selected' : '' }}>Extra orçamentária</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número do talão</label>
                        <input type="number" name="slip_number" class="form-control" value="{{ $recipe->slip_number }}" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Objeto</label>
                <textarea name="object" class="form-control">{{ $recipe->object }}</textarea>
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