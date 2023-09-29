@extends('panel.index')
@section('pageTitle', 'Nova Medida')

@section('breadcrumb')
<li><a href="{{ route('constructions.index') }}">Obras</a></li>
<li><a href="{{ route('measurements.index', $construction->slug) }}">Medições</a></li>
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
        <form action="{{ route('measurements.update', ['construction' => $construction->slug, 'measurement' => $measurement->slug]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Responsável pela execução</label>
                        <input type="text" name="responsible_execution" class="form-control" value="{{ old('responsible_execution', $measurement->responsible_execution) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Responsável pela fiscalização</label>
                        <input type="text" name="responsible_supervision" class="form-control" value="{{ old('responsible_supervision', $measurement->responsible_supervision) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Responsável pela pasta</label>
                        <input type="text" name="folder_manager" class="form-control" value="{{ old('folder_manager', $measurement->folder_manager) }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Período Inicial</label>
                        <input type="date" name="first_date" class="form-control" value="{{ old('first_date', $measurement->first_date) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Período Final</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $measurement->end_date) }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Situação</label>
                        <select name="situation" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Valor devido" {{ $measurement->situation == 'Valor devido' ? 'selected' : '' }}>Valor devido</option>
                            <option value="Empenhado" {{ $measurement->situation == 'Empenhado' ? 'selected' : '' }}>Empenhado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nota fiscal</label>
                        <input type="number" name="invoice" class="form-control" value="{{ old('invoice', $measurement->invoice) }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data da Nota Fiscal</label>
                        <input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date', $measurement->invoice_date) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Valor</label>
                        <input type="text" name="price" class="form-control mask-currency" value="{{ old('price', $measurement->price) }}" />
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