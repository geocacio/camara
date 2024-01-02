@extends('panel.index')
@section('pageTitle', 'Nova Lei')

@section('breadcrumb')
<li><a href="{{ route('laws.index') }}">Lei</a></li>
<li><span>Novo</span></li>
@endsection

@section('content')
<div class="card">
    @if($types->count() <= 0) <div class="alert alert-danger">
        <ul>
            <li>É preciso ter pelo menos um tipo cadastrado! <a href="{{ route('subtypes.create', 'law') }}" class="link-alert alert-danger">Criar</a></li>
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
    <form action="{{ route('laws.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Data</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}" {{ $types->count() <= 0 ? 'disabled' : ''}} />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title1">Selecione o tipo</label>
                    <select name="type_id" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>
                        <option value="">Selecione</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id}}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title1">Selecione a Competência</label>
                    <select name="competency_id" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>
                        <option value="">Selecione</option>
                        @foreach($competencies[0]->children as $competency)
                        <option value="{{ $competency->id}}">{{ $competency->name }}</option>
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
            <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple {{ $types->count() <= 0 ? 'disabled' : ''}}>
        </div>
        <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>{{ old('description') }}</textarea>
        </div>

        <div class="form-footer text-right">
            <button type="submit" class="btn-submit-default">Guardar</button>
        </div>
    </form>
</div>
</div>
@endsection