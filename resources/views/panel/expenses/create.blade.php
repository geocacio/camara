@extends('panel.index')
@section('pageTitle', 'Nova Despesa')

@section('breadcrumb')
<li><a href="{{ route('expenses.index', $voucher->id) }}">Despesa</a></li>
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
        <form action="{{ route('expenses.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md">
                <div class="form-group">
                    <label>Tipo de link</label>
                    <select name="link_type" id="type_item" class="form-control">
                        <option value="internal" {{ old('link_type') == 'internal' ? 'selected' : '' }}>Interno</option>
                        <option value="external" {{ old('link_type') == 'external' ? 'selected' : '' }}>Externo</option>
                        <input type="hidden" name="voucher_id" class="form-control" value="{{ $voucher->id }}" />
                    </select>
                </div>
            </div>
            <div id="internal_link">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Número Credor</label>
                            <input type="number" name="creditor_number" class="form-control" value="{{ old('creditor_number') }}" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Valor da despesa</label>
                            <input type="text" name="valor" class="form-control mask-currency" value="{{ old('valor') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data da despesa</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date') }}" />
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label>Exercício</label>
                            <input type="text" name="exercise" class="form-control" value="{{ old('exercise') }}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fase</label>
                            <select name="fase" class="form-control">
                                <option value="">Selecione</option>
                                <option value="empenhado">EMPENHADO</option>
                                <option value="liquidado">LIQUIDADO</option>
                                <option value="pago">PAGO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Órgão</label>
                            <select name="organ" class="form-control">
                                <option value="">Orgão</option>
                                <option value="Câmara Municipal">Câmara Municipal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Número do pagamento</label>
                            <input type="number" name="payment_number" class="form-control" value="{{ old('payment_number') }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: none" id="external_link">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipe_type">Título do botão</label>
                            <input type="text" name="text_button" class="form-control" value="{{ old('text_button') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>URL</label>
                            <input type="link" name="url" class="form-control" value="{{ old('url') }}" />
                        </div>
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