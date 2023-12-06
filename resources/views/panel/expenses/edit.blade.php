@extends('panel.index')
@section('pageTitle', 'Editar Despesa')

@section('breadcrumb')
<li><a href="{{ route('expenses.index') }}">Despesa</a></li>
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
        <form action="{{ route('expenses.update', $expense->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número Credor</label>
                        <input type="number" name="creditor_number" class="form-control" value="{{ $expense->creditor_number }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Valor da despesa</label>
                        <input type="text" name="valor" class="form-control mask-currency" value="{{ $expense->valor }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data da despesa</label>
                        <input type="date" name="date" class="form-control" value="{{ $expense->date }}" />
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label>Exercício</label>
                        <input type="text" name="exercise" class="form-control" value="{{ $expense->exercise }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fase</label>
                        <select name="fase" class="form-control">
                            <option value="">Selecione</option>
                            <option value="empenhado" {{ old('fase', $expense->fase) == 'empenhado' ? 'selected' : '' }}>EMPENHADO</option>
                            <option value="liquidado" {{ old('fase', $expense->fase) == 'liquidado' ? 'selected' : '' }}>LIQUIDADO</option>
                            <option value="pago" {{ old('fase', $expense->fase) == 'pago' ? 'selected' : '' }}>PAGO</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Órgão</label>
                        <select name="organ" class="form-control">
                            <option value="">Orgão</option>
                            <option value="camara_municipal" {{ old('organ', $expense->organ) == 'camara_municipal' ? 'selected' : '' }} >Camara municipal</option>
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