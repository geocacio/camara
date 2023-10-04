@extends('panel.index')
@section('pageTitle', 'Atualizar Comissão')

@section('breadcrumb')
<li><a href="{{ route('commissions.index') }}">Comissões</a></li>
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
        <form action="{{ route('commissions.update', $commission->slug) }}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_id">Tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($types->count() > 0)
                            @foreach($types as $type)
                            <option value="{{ $type->id}}" {{ $commission->types[0]->id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description', $commission->description) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Informação</label>
                        <textarea name="information" class="form-control">{{ old('information', $commission->information) }}</textarea>
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