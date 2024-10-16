@extends('panel.index')
@section('pageTitle', 'Novo Voucher')

@section('breadcrumb')
    <li><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
    <li><span>Novo</span></li>
@endsection

@section('content')
<div class="card">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul><li>{{ $errors->first() }}</li></ul>
        </div>
    @endif

    <div class="card-body">
        <form id="formVoucher" action="{{ route('vouchers.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número do Voucher</label>
                        <input type="text" name="voucher_number" class="form-control" value="{{ old('voucher_number') }}" autocomplete="off" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="voucher_date" class="form-control" value="{{ old('voucher_date') }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fornecedor</label>
                        <input type="text" name="supplier" class="form-control" value="{{ old('supplier') }}" required autocomplete="off">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Valor</label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Natureza</label>
                <input type="text" name="nature" class="form-control" value="{{ old('nature') }}">
            </div>

            <div class="form-group">
                <label>Categoria Econômica</label>
                <input type="text" name="economic_category" class="form-control" value="{{ old('economic_category') }}">
            </div>

            <div class="form-group">
                <label>Organização</label>
                <input type="text" name="organization" class="form-control" value="{{ old('organization') }}">
            </div>

            <div class="form-group">
                <label>Unidade Orçamentária</label>
                <input type="text" name="budget_unit" class="form-control" value="{{ old('budget_unit') }}">
            </div>

            <div class="form-group">
                <label>Projeto/Atividade</label>
                <input type="text" name="project_activity" class="form-control" value="{{ old('project_activity') }}">
            </div>

            <div class="form-group">
                <label>Função</label>
                <input type="text" name="function" class="form-control" value="{{ old('function') }}">
            </div>

            <div class="form-group">
                <label>Sub-Função</label>
                <input type="text" name="sub_function" class="form-control" value="{{ old('sub_function') }}">
            </div>

            <div class="form-group">
                <label>Fonte de Recursos</label>
                <input type="text" name="resource_source" class="form-control" value="{{ old('resource_source') }}">
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
