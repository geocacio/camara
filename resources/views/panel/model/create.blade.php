@extends('panel.index')
@section('pageTitle', 'Novo Modelo')

@section('breadcrumb')
<li><a href="#">Modelos</a></li>
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
        <form action="#" method="post" enctype="multipart/form-data">
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
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            <option value="">option</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple>
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