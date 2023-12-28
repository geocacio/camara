@extends('panel.index')
@section('pageTitle', 'Novo LRF')

@section('breadcrumb')
<li><a href="{{ route('lrfs.index') }}">LRFs</a></li>
<li><span>Novo</span></li>
@endsection

@section('content')
<div class="card">

    @if($types->count() <= 0)
    <div class="alert alert-danger">
        <ul>
            <li>É preciso ter pelo menos um tipo cadastrado! <a href="{{ route('subtypes.create', 'lrfs') }}" class="link-alert alert-danger">Criar</a></li>
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
    <form action="{{ route('lrfs.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title1">Selecione o tipo</label>
                    <select name="type" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>
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
                    <select name="competence" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>
                        <option value="">Selecione</option>
                        @foreach($competencies[0]->children as $competency)
                        <option value="{{ $competency->id}}">{{ $competency->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title1">Selecione o Exercício</label>
                    <select name="exercicy" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>
                        <option value="">Selecione</option>
                        @foreach($exercicies[0]->children as $exercicy)
                        <option value="{{ $exercicy->id}}">{{ $exercicy->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Data</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}" {{ $types->count() <= 0 ? 'disabled' : ''}} />
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="logo">Arquivo</label>
            <input type="file" name="files[]" class="form-control" multiple {{ $types->count() <= 0 ? 'disabled' : ''}}>
        </div>

        <div class="form-group">
            <label for="logo">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>
        
        <div class="form-group">
            <label>Detalhes</label>
            <textarea name="details" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>{{ old('details') }}</textarea>
        </div>

        <div class="form-footer text-right">
            <button type="submit" class="btn-submit-default" {{ $types->count() <= 0 ? 'disabled' : ''}}>Guardar</button>
        </div>
    </form>
</div>
</div>
@endsection

@section('js')

@include('panel.scripts')

@endsection