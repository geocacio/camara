@extends('panel.index')
@section('pageTitle', 'Atualizar ART')

@section('breadcrumb')
<li><a href="{{ route('constructions.index') }}">Obras</a></li>
<li><a href="{{ route('art.index', $construction->slug) }}">ARTs</a></li>
<li><span>Atualizar</span></li>
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
        <form action="{{ route('art.update', ['construction' => $construction->slug, 'art' => $art->slug]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Responsável</label>
                <input type="text" name="responsible" class="form-control" value="{{ old('responsible', $art->responsible) }}" />
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $art->date) }}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="title1">Tipo</label>
                <select name="type_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($types as $type)
                    <option value="{{ $type->id}}" {{ $type->id == $art->types[0]->id ? 'selected' : '' }}>{{ $type->name}}</option>
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