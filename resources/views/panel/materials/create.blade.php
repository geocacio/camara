@extends('panel.index')
@section('pageTitle', 'Novo Material')

@section('breadcrumb')
<li><a href="{{ route('materials.index') }}">Materiais</a></li>
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
        <form action="{{ route('materials.store') }}" method="post">
            @csrf

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date') }}" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="type_id">Tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($types->count() > 0)
                            @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="status">Situação</label>
                        <select name="status_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($situations->count() > 0)
                            @foreach($situations as $situation)
                            <option value="{{ $situation->id }}">{{ $situation->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="councilor_id">Vereador</label>
                        <select name="councilor_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($councilors->count() > 0)
                            @foreach($councilors as $councilor)
                            <option value="{{ $councilor->id }}">{{ $councilor->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="session_id">Sessão</label>
                        <select name="session_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($sessions->count() > 0)
                            @foreach($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->date }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="file" accept="application/pdf" class="form-control">
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