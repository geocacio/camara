@extends('panel.index')
@section('pageTitle', 'Novo ART')

@section('breadcrumb')
<li><a href="{{ route('constructions.index') }}">Obras</a></li>
<li><a href="{{ route('art.index', $construction->slug) }}">ARTs</a></li>
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
        <form action="{{ route('art.store', $construction->slug) }}" method="post">
            @csrf

            <div class="form-group">
                <label>Responsável</label>
                <input type="text" name="responsible" class="form-control" value="{{ old('responsible') }}" />
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date') }}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="title1">Tipo</label>
                <select name="type_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection