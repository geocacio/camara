@extends('panel.index')
@section('pageTitle', 'Novo Modelo')

@section('breadcrumb')
<li><a href="{{ route('pcg.index') }}">PCGs</a></li>
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
        <form action="{{ route('pcg.store') }}" method="post" enctype="multipart/form-data">
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
                        <label for="title1">Tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}">{{ $type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="title1">Exercício</label>
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($exercicies->children as $exercicy)
                            <option value="{{ $exercicy->id}}">{{ $exercicy->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <h3 class="form-caption">Informações do parecer do tribunal de contas</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Situação</label>
                        <input type="text" name="audit_court_situation" class="form-control" value="{{ old('audit_court_situation') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="court_accounts_date" class="form-control" value="{{ old('court_accounts_date') }}" />
                    </div>
                </div>
            </div>

            <h3 class="form-caption">Informações do julgamento legislativo</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Situação</label>
                        <input type="text" name="legislative_judgment_situation" class="form-control" value="{{ old('legislative_judgment_situation') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="legislative_judgment_date" class="form-control" value="{{ old('legislative_judgment_date') }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="file" accept="application/pdf" class="form-control" multiple>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection