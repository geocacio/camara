@extends('panel.index')
@section('pageTitle', 'Atualizar Expediente')

@section('breadcrumb')
<li><a href="{{ route('sessions.index') }}">Sessões</a></li>
<li><a href="{{ route('proceedings.index', $session->slug) }}">Expedientes</a></li>
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
        <form action="{{ route('proceedings.update', ['session' => $session->slug, 'proceedings' => $proceeding->id]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_id">Tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($types)
                            @foreach($types->children as $type)
                            <option value="{{ $type->id }}" {{ $type->id == $proceeding->type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                            @endif
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