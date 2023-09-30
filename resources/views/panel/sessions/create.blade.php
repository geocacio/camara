@extends('panel.index')
@section('pageTitle', 'Nova Sessão')

@section('breadcrumb')
<li><a href="{{ route('sessions.index') }}">Sessões</a></li>
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
        <form action="{{ route('sessions.store') }}" method="post">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_id">Tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($types)
                            @foreach($types->children as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_id">Status</label>
                        <select name="status_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($status)
                            @foreach($status->children as $statu)
                            <option value="{{ $statu->id }}">{{ $statu->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exercicy_id">Exercício</label>
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($exercicies)
                            @foreach($exercicies->children as $exercicy)
                            <option value="{{ $exercicy->id}}">{{ $exercicy->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
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