@extends('panel.index')
@section('pageTitle', 'Novo Fiscal')

@section('breadcrumb')
<li><a href="{{ route('fiscais.index') }}">Fiscais</a></li>
<li><span>Editar {{ $fiscai->name }}</span></li>
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
        <form action="{{ route('fiscais.update', $fiscai->slug) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $fiscai->name) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de início</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $fiscai->start_date) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de fim</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $fiscai->end_date) }}" />
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo</label>
                        <select name="type" class="form-control">
                            <option value="Fiscal não vigente" @if($fiscai->type == 'Fiscal não vigente') selected @endif>Fiscal não vigente</option>
                            <option value="Fiscal vigente" @if($fiscai->type == 'Fiscal vigente') selected @endif>Fiscal vigente</option>
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