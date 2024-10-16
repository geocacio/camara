@extends('panel.index')
@section('pageTitle', 'Editar Liquidação')

@section('breadcrumb')
    <li><a href="{{ route('liquidation.index', $liquidation->voucher_id) }}">Liquidações</a></li>
    <li><span>Editar</span></li>
@endsection

@section('content')
<div class="card">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul><li>{{ $errors->first() }}</li></ul>
        </div>
    @endif

    <div class="card-body">
        <form id="formLiquidation" action="{{ route('liquidation.update', $liquidation->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Data da Liquidação</label>
                <input type="date" name="liquidation_date" class="form-control" 
                       value="{{ old('liquidation_date', $liquidation->liquidation_date) }}">
            </div>

            <div class="form-group">
                <label>Número da Nota Fiscal</label>
                <input type="text" name="invoice_number" class="form-control" 
                       value="{{ old('invoice_number', $liquidation->invoice_number) }}" autocomplete="off">
            </div>

            <div class="form-group">
                <label>Exercício Fiscal</label>
                <input type="number" name="fiscal_year" class="form-control" 
                       value="{{ old('fiscal_year', $liquidation->fiscal_year) }}">
            </div>

            <div class="form-group">
                <label>Valor</label>
                <input type="number" step="0.01" name="amount" class="form-control" 
                       value="{{ old('amount', $liquidation->amount) }}">
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection
