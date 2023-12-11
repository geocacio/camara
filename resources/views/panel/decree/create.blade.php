@extends('panel.index')
@section('pageTitle', 'Novo Decreto')

@section('breadcrumb')
<li><a href="{{ route('decrees.index') }}">Decretos</a></li>
<li><span>Novo</span></li>
@endsection

@section('content')
<div class="card">
    @if(is_array($types) && count($types) <= 0)
    <div class="alert alert-danger">
        <ul>
            <li>É preciso ter pelo menos um tipo cadastrado! <a href="{{ route('subtypes.create', 'decrees') }}" class="link-alert alert-danger">Criar</a></li>
        </ul>
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
    <form action="{{ route('decrees.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Número</label>
                    <input type="number" name="number" class="form-control" value="{{ old('number') }}" {{ is_array($types) && count($types) <= 0 ? 'disabled' : '' }}/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Data</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}" {{ is_array($types) && count($types) <= 0 ? 'disabled' : '' }} />
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="title1">Selecione o Exercício</label>
                    <select name="exercicy_id" class="form-control" {{ is_array($types) && count($types) <= 0 ? 'disabled' : '' }}>
                        <option value="">Selecione</option>
                        @foreach($exercicies[0]->children as $exercicy)
                        <option value="{{ $exercicy->id}}">{{ $exercicy->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title1">Selecione o tipo</label>
                    <select name="type" class="form-control" {{ is_array($types) && count($types) <= 0 ? 'disabled' : '' }}>
                        <option value="">Selecione</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id}}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title1">Selecione o Grupo</label>
                    <select name="group_id" class="form-control" {{ is_array($types) && count($types) <= 0 ? 'disabled' : '' }}>
                        <option value="">Selecione</option>
                        @foreach($groups[0]->children as $group)
                        <option value="{{ $group->id}}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <!-- <div class="form-group">
                <label>Exercício</label>
                <input type="number" name="year_of_promulgation" class="form-control" value="{{ old('year_of_promulgation') }}" />
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <select name="type" class="form-control">
                    <option value="">Selecione</option>
                    <option value="Lei Municipal">Lei Municipal</option>
                    <option value="Regime Jurídico">Regime Jurídico</option>
                    <option value="Lei complementar">Lei complementar</option>
                    <option value="Portaria">Portaria</option>
                </select>
            </div> -->



        <div class="form-group">
            <label for="logo">Arquivo</label>
            <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple {{ is_array($types) && count($types) <= 0 ? 'disabled' : '' }}>
        </div>
        <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" class="form-control" {{ is_array($types) && count($types) <= 0 ? 'disabled' : '' }}>{{ old('description') }}</textarea>
        </div>

        <div class="form-footer text-right">
            <button type="submit" class="btn-submit-default">Guardar</button>
        </div>
    </form>
</div>
</div>
@endsection