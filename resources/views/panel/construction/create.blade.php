@extends('panel.index')
@section('pageTitle', 'Nova obra')

@section('breadcrumb')
<li><a href="{{ route('constructions.index') }}">Obras</a></li>
<li><span>Nova</span></li>
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
        <form action="{{ route('constructions.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date') }}" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="title1">Selecione a Secretaria</label>
                        <select name="secretary_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($secretaries as $secretary)
                            <option value="{{ $secretary->id}}">{{ $secretary->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="title1">Selecione o tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}">{{ $type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Local</label>
                        <input type="text" name="local" class="form-control" value="{{ old('local') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data prevista</label>
                        <input type="date" name="expected_date" class="form-control" value="{{ old('expected_date') }}" />
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